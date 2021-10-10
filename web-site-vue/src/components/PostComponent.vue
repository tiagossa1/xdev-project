<template>
  <b-container
    :style="{ border: '2px solid gray', 'border-radius': '25px' }"
    class="bv-example-row p-4 ml-4 mb-4"
  >
    <b-badge
      class="mb-4 ml-4 p-2 no-select"
      :style="{
        backgroundColor: post.user.userType.hexColorCode,
      }"
    >
      <b-icon :icon="post.postType.iconName"></b-icon> {{ post.postType.name }}
    </b-badge>
    <post-options-component
      @on-deleted="onDeleted"
      @on-edit="onEdit"
      :post="post"
    ></post-options-component>
    <b-row>
      <b-col>
        <span v-for="tag in post.tags" :key="tag.id" class="mr-4">
          <b-badge pill variant="info">{{ tag.name }}</b-badge>
        </span>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-container>
          <b-row class="justify-content-center">
            <b-avatar
              :src="post.user.profile_picture"
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

    <b-row class="mt-3 ml-2">
      <b-col>
        <template v-if="toEdit">
          <b-form-input v-model="post.title" :value="post.title"></b-form-input>
        </template>
        <template v-else>
          <h2 class="font-weight-bold">{{ post.title }}</h2>
        </template>
      </b-col>
    </b-row>

    <b-row class="mt-2 ml-2 mb-4">
      <b-col>
        <template v-if="toEdit">
          <quill-editor ref="myQuillEditor" v-model="post.description">
          </quill-editor>
        </template>
        <template v-else>
          <span class="h5" v-html="post.description"></span>
        </template>
      </b-col>
    </b-row>

    <b-row class="ml-2 mt-2">
      <b-col cols="2" style="cursor: pointer" @click="onLike">
        <p class="h5">
          <b-icon
            :icon="liked ? 'heart-fill' : 'heart'"
            :variant="liked ? 'liked' : ''"
            class="mr-1"
          ></b-icon>
          {{ liked ? "Gosto" : "Gostar" }}
        </p>
      </b-col>
      <b-col cols="3" style="cursor: pointer" @click="onSave">
        <p class="h5">
          <b-icon
            :variant="saved ? 'danger' : ''"
            :icon="saved ? 'bookmark-fill' : 'bookmark'"
            class="mr-1"
          ></b-icon>
          {{ saved ? "Guardado" : "Guardar" }}
        </p>
      </b-col>
      <b-col
        cols="3"
        v-if="toEdit && isUserPost"
        style="cursor: pointer"
        @click="onEdited"
      >
        <p class="h5">
          <b-icon icon="pencil" class="mr-1"> </b-icon>
          Terminar edição
        </p>
      </b-col>
    </b-row>

    <b-row class="ml-2 mt-2 mr-2">
      <b-col>
        <b-button
          v-if="post.comments.length > 0"
          class="text-white mt-2 mb-2"
          :aria-expanded="modalVisible ? 'true' : 'false'"
          :aria-controls="collapseId"
          @click="modalVisible = !modalVisible"
          variant="primary"
          >Mostrar {{ post.comments.length }} comentários
          <b-icon-arrow-down></b-icon-arrow-down
        ></b-button>
        <b-collapse :id="collapseId" class="mt-2" v-model="modalVisible">
          <transition-group name="fade" tag="div">
            <div v-for="comment in post.comments" :key="comment.id">
              <post-comment-component
                @on-deleted="onDeleted"
                class="mb-3"
                :comment="comment"
                :ref="comment.id"
              ></post-comment-component>
            </div>
          </transition-group>
        </b-collapse>

        <b-form @submit.prevent="onSubmit">
          <b-form-input
            v-model="comment"
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

export default {
  name: "post-component",
  components: { PostCommentComponent, PostOptionsComponent },
  props: {
    post: Post,
  },
  mounted() {
    this.isUserPost = this.$store.getters["auth/user"].id === this.post.user.id;
  },
  data() {
    return {
      liked: this.post.userLikes.includes(this.$store.getters["auth/user"].id),
      saved: this.post.usersSaved.includes(this.$store.getters["auth/user"].id),
      comment: "",
      isUserPost: false,
      collapseId: "collapse-" + this.post.id,
      redirectProfile: `/profile/${this.post.user.id}`,
      toEdit: false,
      modalVisible: false,
    };
  },
  methods: {
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

      await postService.changeLikePost(this.post.id, this.post.userLikes);

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

      await postService.changeSavedPost(this.post.id, this.post.usersSaved);
      this.saved = !this.saved;
    },

    async onSubmit() {
      if (this.comment) {
        const request = new CommentRequest(
          this.comment,
          this.$store.getters["auth/user"].id,
          this.post.id
        );

        let res = await commentService.createComment(request);

        if (res) {
          this.post.comments.push(res);
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
      this.toEdit = toEdit;
    },

    async onEdited() {
      let request = new PostRequest(
        this.post.id,
        this.post.title,
        this.post.description,
        this.post.suspended,
        this.post.userId,
        this.post.postTypeId
      );

      let res = await postService
        .updatePost(request)
        .catch((err) => console.log(err.response));

      // TODO: response status should be 200, not 20

      if (res.status === 201) {
        this.$root.$emit("show-alert", {
          alertMessage: "Post editado com sucesso!",
          variant: "success",
        });
        this.toEdit = false;
      }
    },
  },
};
</script>
