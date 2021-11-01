<template>
  <b-container :style="getPostStyle" class="bv-example-row p-3 mb-4 x">
    <b-row class="ml-2 mr-2 mb-3">
      <b-col v-if="!toEdit">
        <span v-for="tag in tagsToShow" :key="tag.id" class="mr-4">
          <b-badge class="p-2 no-select" pill variant="secondary">{{
            tag.name
          }}</b-badge>
        </span>
        <b-badge
          v-if="hiddenTags > 0"
          v-b-tooltip.hover
          :title="tagNames"
          class="p-2 no-select align-middle"
          pill
          variant="secondary"
        >
          +{{ hiddenTags }}
        </b-badge>
      </b-col>
      <b-col v-else>
        <b-form-group label-for="tags-component-select">
          <b-form-tags
            id="tags-component-select"
            v-model="editSelectedTags"
            size="lg"
            class="mb-2"
            :limit="limitTag"
            add-on-change
            no-outer-focus
          >
            <template
              v-slot="{
                tags,
                inputAttrs,
                inputHandlers,
                disabled,
                removeTag,
              }"
            >
              <ul
                v-if="tags.length > 0"
                class="list-inline d-inline-block mb-2"
              >
                <li v-for="tag in tags" :key="tag" class="list-inline-item">
                  <b-form-tag
                    @remove="removeTag(tag)"
                    :title="tag"
                    :disabled="disabled"
                    variant="primary"
                    class="text-white"
                    >{{ tag }}</b-form-tag
                  >
                </li>
              </ul>
              <b-form-select
                v-bind="inputAttrs"
                v-on="inputHandlers"
                :disabled="
                  disabled ||
                    availableOptions.length === 0 ||
                    editSelectedTags.length >= 6
                "
                :options="availableOptions"
              >
                <template #first>
                  <!-- This is required to prevent bugs with Safari -->
                  <option disabled value="">Escolha uma tag...</option>
                </template>
              </b-form-select>
            </template>
          </b-form-tags>
        </b-form-group>
      </b-col>
      <span
        v-b-tooltip.right="
          'Este post foi suspenso por um moderador. Por favor, edite-o para voltar a ser visível para a comunidade.'
        "
      >
        <b-icon
          v-if="propPost.suspended"
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
        backgroundColor: propPost.user.userType.hexColorCode,
      }"
    >
      <b-icon :icon="propPost.postType.iconName"></b-icon>
      {{ propPost.postType.name }}
    </b-badge>

    <b-row v-if="toEdit" class="mt-2 ml-2 mr-2 mb-3">
      <b-col>
        <b-form-select
          v-model="propPost.postType.name"
          :options="postTypesSelect"
        ></b-form-select>
      </b-col>
    </b-row>
    <post-options-component
      v-if="!viewOnly && !toEdit"
      @on-deleted="onDeleted"
      @on-edit="onEdit"
      :post="propPost"
    ></post-options-component>

    <b-row class="ml-1">
      <b-col>
        <b-container>
          <b-row class="justify-content-center">
            <b-avatar
              :src="propPost.user.profile_picture"
              size="5rem"
              :style="{
                border: '3px solid ' + propPost.user.userType.hexColorCode,
              }"
              :href="redirectProfile"
            ></b-avatar>
          </b-row>

          <b-row class="justify-content-center mt-1">
            <b-badge
              :to="redirectProfile"
              class="rounded-35 text-center"
              :style="{ backgroundColor: propPost.user.userType.hexColorCode }"
            >
              {{ propPost.user.userType.name }}
            </b-badge>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="10">
        <b-link
          class="font-weight-bold"
          :style="{ color: propPost.user.userType.hexColorCode }"
          :href="redirectProfile"
          >{{ propPost.user.name }}</b-link
        >
        <br />
        <small>
          {{ propPost.user.schoolClass.name }} |
          {{ propPost.user.schoolClass.school.name }}</small
        ><br />
        <small>Adicionado {{ propPost.createdAt }}</small>
      </b-col>
    </b-row>

    <b-row class="mt-2 ml-2 mr-2">
      <b-col>
        <template v-if="toEdit">
          <b-form-input
            class="mt-2 mb-3"
            v-model="propPost.title"
            :value="propPost.title"
          ></b-form-input>
        </template>
        <template v-else>
          <h3 class="font-weight-bold">{{ propPost.title }}</h3>
        </template>
      </b-col>
    </b-row>

    <b-row class="ml-2 mr-2 mb-2">
      <b-col>
        <template v-if="toEdit">
          <quill-editor
            class="mb-2"
            ref="myQuillEditor"
            v-model="propPost.description"
          >
          </quill-editor>
        </template>
        <template v-else>
          <span class="h6 w-25 h-25" v-html="propPost.description"></span>
        </template>
      </b-col>
    </b-row>

    <b-row v-if="!viewOnly" class="ml-2 mt-3">
      <b-col
        v-if="!propPost.suspended"
        cols="1"
        style="cursor: pointer"
        @click="onLike"
      >
        <p class="h5">
          <b-icon
            scale="1"
            :icon="liked ? 'heart-fill' : 'heart'"
            :variant="liked ? 'liked' : ''"
          ></b-icon>
        </p>
      </b-col>
      <b-col
        v-if="!propPost.suspended"
        class="cursor-pointer"
        cols="1"
        @click="toComment = !toComment"
      >
        <b-icon scale="1.2" icon="chat" class=""></b-icon>
      </b-col>
      <b-col
        v-if="!propPost.suspended"
        class="cursor-pointer"
        cols="1"
        @click="onSave"
      >
        <p class="h5">
          <b-icon
            scale="1"
            :variant="saved ? 'danger' : ''"
            :icon="saved ? 'bookmark-fill' : 'bookmark'"
          ></b-icon>
        </p>
      </b-col>

      <b-col
        cols="2"
        v-if="toEdit && isUserPost"
        style="cursor: pointer"
        @click="onEdited"
      >
        <p class="h5">
          <b-icon icon="pencil" class="mr-1"></b-icon>
          <span class="small ml-2">Editar</span>
        </p>
      </b-col>
      <b-col
        cols="3"
        v-if="toEdit && isUserPost"
        style="cursor: pointer"
        @click="onCancel"
      >
        <p class="h5">
          <b-icon icon="x" class="mr-1"></b-icon>
          <span class="small ml-2">Cancelar</span>
        </p>
      </b-col>
    </b-row>
    <hr v-if="post.comments.length > 0" />
    <b-row class="ml-2 mr-2">
      <b-col>
        <a href="" onclick="return false;">
          <p
            v-if="propPost.comments.length > 0"
            class="mt-2 mb-2 text-dark"
            :aria-expanded="modalVisible ? 'true' : 'false'"
            :aria-controls="collapseId"
            @click="modalVisible = !modalVisible"
          >
            {{ modalVisible ? "Esconder" : "Mostrar" }}
            {{ propPost.comments.length }} comentários
            <b-icon :icon="modalVisible ? 'arrow-down' : 'arrow-up'"></b-icon>
          </p>
        </a>

        <b-collapse :id="collapseId" class="mt-2" v-model="modalVisible">
          <transition-group name="fade" tag="div">
            <div v-for="comment in propPost.comments" :key="comment.id">
              <post-comment-component
                @on-deleted="onDeleted"
                class="mb-3"
                :viewOnly="viewOnly"
                :comment="comment"
                :post-id="propPost.id"
                :ref="comment.id"
              ></post-comment-component>
            </div>
          </transition-group>
        </b-collapse>

        <transition
          enter-active-class="animated fadeIn"
          leave-active-class="animated fadeOut"
        >
          <quill-editor
            v-if="toComment && !viewOnly && !propPost.suspended"
            class="mt-3"
            ref="myQuillEditor"
            :options="{ placeholder: 'Escreva um comentário...' }"
            v-model="comment"
          >
          </quill-editor>
        </transition>

        <transition
          enter-active-class="animated fadeIn"
          leave-active-class="animated fadeOut"
        >
          <p
            v-if="toComment && comment"
            class="h6 mt-2 cursor-pointer d-flex align-items-center float-right"
            @click="onSubmit"
          >
            <b-icon icon="check" font-scale="1.8" variant="success"></b-icon>
            Comentar
          </p>
        </transition>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import PostCommentComponent from "./PostCommentComponent.vue";
import PostOptionsComponent from "./PostOptionsComponent.vue";

import postService from "../services/postService";
import commentService from "../services/commentService";
import tagService from "../services/tagService";

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
    this.isUserPost =
      this.$store.getters["auth/user"].id === this.propPost.user.id;

    if (this.isUserPost) {
      this.getPostTypes();
      this.redirectProfile = "/profile/";
    } else {
      this.redirectProfile = `/profile/${this.propPost.user.id}`;
    }

    // this.tagsToShow = this.propPost.tags.splice(0, 3);
    // this.hiddenTags = this.propPost.tags.splice()

    // console.log(this.propPost);
  },
  data() {
    return {
      paramId: null,
      propPost: this.post,
      tagsToShow: this.post.tags.slice(0, 3),
      hiddenTags: this.post.tags.slice(3, this.post.tags.length).length,
      tagNames: this.post.tags.map((t) => t.name).join(", "),
      liked: this.post.userLikes.includes(this.$store.getters["auth/user"].id),
      saved: this.post.usersSaved.includes(this.$store.getters["auth/user"].id),
      comment: "",
      isUserPost: false,
      collapseId: "collapse-" + this.post.id,
      redirectProfile: "",
      postTypes: [],
      postTypesSelect: [],
      tags: [],
      tagsSelect: [],
      editSelectedTags: [],
      limitTag: 6,
      toEdit: false,
      modalVisible: false,
      toComment: false,
    };
  },
  computed: {
    getPostStyle() {
      return {
        borderRadius: "10px",
        backgroundColor: "white",
        border:
          this.propPost.suspended === 1 ? "1px solid red" : "1px solid gray",
      };
    },
    availableOptions() {
      return this.tagsSelect.filter(
        (opt) => this.editSelectedTags.indexOf(opt) === -1
      );
    },
  },
  methods: {
    async getPostTypes() {
      let postTypes = await postService.getPostTypes();
      this.postTypes = postTypes;

      this.postTypesSelect = this.postTypes.map((pt) => pt.name);
    },
    async onLike() {
      if (this.liked) {
        const indexToRemove = this.propPost.userLikes.indexOf(
          this.$store.getters["auth/user"].id
        );

        if (indexToRemove > -1) {
          this.propPost.userLikes.splice(indexToRemove, 1);
        }
      } else {
        this.propPost.userLikes.push(this.$store.getters["auth/user"].id);
      }

      let request = new PostRequest(
        this.propPost.id,
        this.propPost.title,
        this.propPost.description,
        this.propPost.suspended,
        this.propPost.user.id,
        this.propPost.postType.id,
        this.propPost.userLikes,
        null,
        this.propPost.usersSaved
      );

      await postService.update(request).catch((err) => {
        let error;

        if (err.response.data.errors) {
          error = Object.values(err.response.data.errors)
            .map((v) => v.join(", "))
            .join(", ");
        }

        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: error ?? err.response.data.message,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });

      this.liked = !this.liked;
    },
    async onSave() {
      if (this.saved) {
        const indexToRemove = this.propPost.usersSaved.indexOf(
          this.$store.getters["auth/user"].id
        );

        if (indexToRemove > -1) {
          this.propPost.usersSaved.splice(indexToRemove, 1);
        }
      } else {
        this.propPost.usersSaved.push(this.$store.getters["auth/user"].id);
      }

      let request = new PostRequest(
        this.propPost.id,
        this.propPost.title,
        this.propPost.description,
        this.propPost.suspended,
        this.propPost.user.id,
        this.propPost.postType.id,
        this.propPost.userLikes,
        null,
        this.propPost.usersSaved
      );

      await postService.update(request).catch((err) => {
        let error;

        if (err.response.data.errors) {
          error = Object.values(err.response.data.errors)
            .map((v) => v.join(", "))
            .join(", ");
        }

        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: error ?? err.response.data.message,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });

      this.saved = !this.saved;

      if (!this.saved) {
        this.$emit("on-unsaved", this.propPost.id);
      }
    },
    async onSubmit() {
      if (this.comment) {
        const request = new CommentRequest(
          null,
          this.comment,
          this.$store.getters["auth/user"].id,
          this.propPost.id
        );

        let res = await commentService.create(request).catch((err) => {
          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors)
              .map((v) => v.join(", "))
              .join(", ");
          }

          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: error ?? err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

        if (res.data.data) {
          let comment = new Comment(res.data.data);
          this.propPost.comments.push(comment);
          this.comment = "";

          this.modalVisible = true;
        }

        this.toComment = false;
      }
    },
    onDeleted(deleteOptions) {
      if (deleteOptions.isPost) {
        this.$emit("on-post-deleted", deleteOptions.id);
      } else if (deleteOptions.isComment) {
        this.$emit("on-comment-deleted", deleteOptions.id);
      }
    },
    async onEdit(toEdit) {
      this.toEdit = toEdit;

      this.tags = await tagService.getTags();
      this.tagsSelect = this.tags.map((t) => t.name);
      this.editSelectedTags = this.propPost.tags.map((t) => t.name);
    },
    async onEdited() {
      let originalPost = await postService.getPostById(this.propPost.id);

      const validation = this.propPost.suspended
        ? JSON.stringify(originalPost) !== JSON.stringify(this.propPost)
        : true;

      if (validation) {
        let postTypeId = this.postTypes.find(
          (pt) => pt.name === this.propPost.postType.name
        )?.id;

        let tags = this.tags.filter((t) =>
          this.editSelectedTags.includes(t.name)
        );

        let request = new PostRequest(
          this.propPost.id,
          this.propPost.title,
          this.propPost.description,
          false,
          this.propPost.user.id,
          postTypeId,
          null,
          tags.map((t) => t.id),
          null
        );

        let res = await postService.update(request).catch((err) => {
          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors)
              .map((v) => v.join(", "))
              .join(", ");
          }

          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: error ?? err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

        if (res.status === 200) {
          this.propPost.suspended = false;

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Post editado.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });

          this.propPost.tags = tags;

          this.propPost.postType = this.postTypes.find(
            (pt) => pt.name === this.propPost.postType.name
          );
        }
      }

      this.toEdit = false;
    },
    async onCancel() {
      let originalPost = await postService.getPostById(this.propPost.id);
      this.propPost = originalPost;

      this.toEdit = false;
    },
  },
};
</script>

<style scoped>
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

.ql-editor::before {
  content: attr(data-placeholder);
}
</style>
