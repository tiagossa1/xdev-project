<template>
  <b-container
    :style="
      !post.suspended
        ? {
            border: '2px solid gray',
            'border-radius': '25px',
            backgroundColor: '#dee2e6',
          }
        : {
            border: '2px solid red ',
            'border-radius': '25px',
            backgroundColor: '#dee2e6',
          }
    "
    class="bv-example-row p-3 ml-4 mb-4 x"
  >
    <b-row class="ml-2 mb-3">
      <b-col>
        <span v-for="tag in post.tags" :key="tag.id" class="mr-4">
          <b-badge class="p-2" pill variant="secondary">{{ tag.name }}</b-badge>
        </span>
      </b-col>
      <span
        v-b-tooltip.right="
          'Este post foi suspenso por um moderador. Por favor, edite-o para voltar a ser visível para a comunidade.'
        "
      >
        <b-icon
          v-if="post.suspended"
          icon="exclamation-triangle"
          class="mr-4 float-right"
          variant="danger"
          font-scale="2"
        ></b-icon>
      </span>
    </b-row>
    <b-badge
      class="mb-4 ml-4 p-2 no-select"
      v-if="!toEdit"
      :style="{
        backgroundColor: post.user.userType.hexColorCode,
      }"
    >
      <b-icon :icon="post.postType.iconName"></b-icon> {{ post.postType.name }}
    </b-badge>

    <b-row v-if="toEdit" class="mt-2 ml-2 mb-3">
      <b-col>
        <b-form-select
          v-model="post.postType.name"
          :options="postTypesSelect"
        ></b-form-select>
      </b-col>
    </b-row>
    <post-options-component
      v-if="!viewOnly && !toEdit"
      @on-deleted="onDeleted"
      @on-edit="onEdit"
      :post="post"
    ></post-options-component>

    <b-row>
      <b-col>
        <b-container>
          <b-row class="justify-content-center">
            <b-avatar
              :src="'data:image/jpeg;base64,' + post.user.profile_picture"
              size="5rem"
              :style="{
                border: '3px solid ' + post.user.userType.hexColorCode,
              }"
              :href="redirectProfile"
            ></b-avatar>
          </b-row>

          <b-row class="justify-content-center mt-1">
            <b-badge
              :to="redirectProfile"
              class="rounded-35 text-center"
              :style="{ backgroundColor: post.user.userType.hexColorCode }"
            >
              {{ post.user.userType.name }}
            </b-badge>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="10">
        <b-link
          class="font-weight-bold"
          :style="{ color: post.user.userType.hexColorCode }"
          :href="redirectProfile"
          >{{ post.user.name }}</b-link
        >
        <br />
        <small>
          {{ post.user.schoolClass.name }} |
          {{ post.user.schoolClass.school.name }}</small
        ><br />
        <small>Adicionado {{ post.createdAt }}</small>
      </b-col>
    </b-row>

    <b-row class="mt-2 ml-2">
      <b-col>
        <template v-if="toEdit">
          <b-form-input
            class="mt-2 mb-3"
            v-model="post.title"
            :value="post.title"
          ></b-form-input>
        </template>
        <template v-else>
          <h3 class="font-weight-bold">{{ post.title }}</h3>
        </template>
      </b-col>
    </b-row>

    <b-row class="ml-2 mb-2">
      <b-col>
        <template v-if="toEdit">
          <quill-editor
            class="mb-2"
            ref="myQuillEditor"
            v-model="post.description"
          >
          </quill-editor>
        </template>
        <template v-else>
          <span class="h6 w-25 h-25" v-html="post.description"></span>
        </template>
      </b-col>
    </b-row>

    <b-row v-if="!viewOnly" class="ml-2">
      <b-col
        v-if="!post.suspended"
        cols="2"
        style="cursor: pointer"
        @click="onLike"
      >
        <p class="h5">
          <b-icon
            :icon="liked ? 'heart-fill' : 'heart'"
            :variant="liked ? 'liked' : ''"
            class="mr-1"
          ></b-icon>
          <span class="small"> {{ liked ? "Gosto" : "Gostar" }} </span>
        </p>
      </b-col>
      <b-col
        v-if="!post.suspended"
        cols="3"
        style="cursor: pointer"
        @click="onSave"
      >
        <p class="h5">
          <b-icon
            :variant="saved ? 'danger' : ''"
            :icon="saved ? 'bookmark-fill' : 'bookmark'"
            class="mr-1"
          ></b-icon>
          <span class="small"> {{ saved ? "Guardado" : "Guardar" }} </span>
        </p>
      </b-col>

      <b-col
        cols="3"
        v-if="toEdit && isUserPost"
        style="cursor: pointer"
        @click="onEdited"
      >
        <p class="h5">
          <b-icon icon="pencil" class="mr-1"></b-icon>
          <span class="small ml-2">Terminar edição</span>
        </p>
      </b-col>
    </b-row>
    <hr />
    <b-row class="ml-2 mr-2">
      <b-col>
        <a href="" onclick="return false;">
          <p
            v-if="post.comments.length > 0"
            class="mt-2 mb-2 text-dark"
            :aria-expanded="modalVisible ? 'true' : 'false'"
            :aria-controls="collapseId"
            @click="modalVisible = !modalVisible"
          >
            Mostrar {{ post.comments.length }} comentários
            <b-icon :icon="modalVisible ? 'arrow-down' : 'arrow-up'"></b-icon>
            <!-- <b-icon-arrow-down></b-icon-arrow-down -->
          </p>
        </a>

        <b-collapse :id="collapseId" class="mt-2" v-model="modalVisible">
          <transition-group name="fade" tag="div">
            <div v-for="comment in post.comments" :key="comment.id">
              <post-comment-component
                @on-deleted="onDeleted"
                class="mb-3"
                :viewOnly="viewOnly"
                :comment="comment"
                :ref="comment.id"
              ></post-comment-component>
            </div>
          </transition-group>
        </b-collapse>

        <b-form v-if="!viewOnly && !post.suspended" @submit.prevent="onSubmit">
          <b-form-input
            v-model="comment"
            class="commentInput"
            placeholder="Escreva o seu comentário aqui..."
          ></b-form-input>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import PostCommentComponent from "./PostCommentComponent.vue";
import PostOptionsComponent from "./PostOptionsComponent.vue";

import postService from "../services/postService";
import commentService from "../services/commentService";

import Post from "../models/post";
import PostRequest from "../models/requests/postRequest";
import CommentRequest from "../models/requests/commentRequest";
import Comment from "../models/comment";

export default {
  name: "post-component",
  components: { PostCommentComponent, PostOptionsComponent },
  props: {
    post: Post,
    viewOnly: {
      default: false,
      type: Boolean,
    },
  },
  async mounted() {
    this.isUserPost = this.$store.getters["auth/user"].id === this.post.user.id;
    if (this.isUserPost) {
      this.getPostTypes();
      this.redirectProfile = "/profile/";
    } else {
      this.redirectProfile = `/profile/${this.post.user.id}`;
    }
  },
  data() {
    return {
      paramId: null,
      backupPost: null,
      liked: this.post.userLikes.includes(this.$store.getters["auth/user"].id),
      saved: this.post.usersSaved.includes(this.$store.getters["auth/user"].id),
      comment: "",
      isUserPost: false,
      collapseId: "collapse-" + this.post.id,
      redirectProfile: "",
      postTypes: [],
      postTypesSelect: [],
      toEdit: false,
      modalVisible: false,
    };
  },
  methods: {
    async getPostTypes() {
      let postTypes = await postService.getPostTypes();
      this.postTypes = postTypes;

      this.postTypesSelect = this.postTypes.map((pt) => pt.name);
    },
    async onLike() {
      if (this.liked) {
        const indexToRemove = this.post.userLikes.indexOf(
          this.$store.getters["auth/user"].id
        );

        if (indexToRemove > -1) {
          this.post.userLikes.splice(indexToRemove, 1);
        }
      } else {
        this.post.userLikes.push(this.$store.getters["auth/user"].id);
      }

      let request = new PostRequest(
        this.post.id,
        this.post.title,
        this.post.description,
        this.post.suspended,
        this.post.user.id,
        this.post.postType.id,
        this.post.userLikes,
        null,
        this.post.usersSaved
      );

      await postService
        .update(request)
        .catch((err) => console.log(err.response));

      this.liked = !this.liked;
    },
    async onSave() {
      if (this.saved) {
        const indexToRemove = this.post.usersSaved.indexOf(
          this.$store.getters["auth/user"].id
        );

        if (indexToRemove > -1) {
          this.post.usersSaved.splice(indexToRemove, 1);
        }
      } else {
        this.post.usersSaved.push(this.$store.getters["auth/user"].id);
      }

      let request = new PostRequest(
        this.post.id,
        this.post.title,
        this.post.description,
        this.post.suspended,
        this.post.user.id,
        this.post.postType.id,
        this.post.userLikes,
        null,
        this.post.usersSaved
      );

      await postService.update(request).catch((err) => {
        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: err.response.data,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 3500,
        });
      });

      this.saved = !this.saved;
    },
    async onSubmit() {
      if (this.comment) {
        const request = new CommentRequest(
          null,
          this.comment,
          this.$store.getters["auth/user"].id,
          this.post.id
        );

        let res = await commentService.create(request).catch((err) => {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: err.response.data,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });
        });

        if (res.data.data) {
          let comment = new Comment(res.data.data);

          this.post.comments.push(comment);
          this.comment = "";

          this.modalVisible = true;
        }
      }
    },
    onDeleted(deleteOptions) {
      if (deleteOptions.isPost) {
        this.$emit("on-post-deleted", deleteOptions.id);
      } else if (deleteOptions.isComment) {
        this.$emit("on-comment-deleted", deleteOptions.id);
      }
    },
    onEdit(toEdit) {
      this.backupPost = this.post;
      this.toEdit = toEdit;
    },
    async onEdited() {
      let originalPost = await postService.getPostById(this.post.id);

      if (JSON.stringify(originalPost) !== JSON.stringify(this.post)) {
        let postTypeId = this.postTypes.find(
          (pt) => pt.name === this.post.postType.name
        )?.id;

        if (this.post.suspended) {
          this.post.suspended = false;
        }

        let request = new PostRequest(
          this.post.id,
          this.post.title,
          this.post.description,
          this.post.suspended,
          this.post.user.id,
          postTypeId,
          null,
          null,
          null
        );

        let res = await postService.update(request).catch((err) => {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: err.response.data,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });
        });

        if (res.status === 200) {
          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Post criado.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });

          this.post.postType = this.postTypes.find(
            (pt) => pt.name === this.post.postType.name
          );
        }
      }

      this.toEdit = false;
    },
  },
};
</script>

<style>
img {
  width: 100%;
  height: 100%;
}
.x {
  -webkit-box-shadow: 0 10px 6px -6px #777;
  -moz-box-shadow: 0 10px 6px -6px #777;
  box-shadow: 0 10px 6px -6px #777;
}
hr {
  width: 90%;
}
.commentInput {
  box-shadow: 0 0 3px gray;
}
</style>
