<template>
  <b-container
    :style="{ border: '2px solid gray', 'border-radius': '25px' }"
    class="bv-example-row p-4 ml-4 mb-4"
  >
    <post-options-component
      @on-deleted="onDeleted"
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
            ></b-avatar>
          </b-row>
          <b-row class="justify-content-center mt-1">
            <b-badge
              class="rounded-35 text-center"
              :style="{ backgroundColor: post.user.userType.hexColorCode }"
            >
              {{ post.user.userType.name }}
            </b-badge>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="10">
        <span
          class="font-weight-bold"
          :style="{ color: post.user.userType.hexColorCode }"
        >
          {{ post.user.name }}
        </span>
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
        <h3 class="font-weight-bold">{{ post.title }}</h3>
      </b-col>
    </b-row>

    <b-row class="ml-2 mt-2">
      <b-col cols="2" style="cursor: pointer" @click="onLike">
        <p class="h5">
          <b-icon
            :icon="liked ? 'heart-fill' : 'heart'"
            :variant="liked ? 'liked' : ''"
            >Like</b-icon
          >
          Like
        </p>
      </b-col>
      <b-col cols="10" style="cursor: pointer" @click="onSave">
        <p class="h5">
          <b-icon
            :variant="saved ? 'danger' : ''"
            :icon="saved ? 'bookmark-fill' : 'bookmark'"
            >Bookmark</b-icon
          >
          {{ saved ? "Guardado" : "Guardar" }}
        </p>
      </b-col>
    </b-row>

    <div v-for="comment in post.comments" :key="comment.id">
      <post-comment-component
        @on-deleted="onDeleted"
        class="mt-3"
        :comment="comment"
      ></post-comment-component>
    </div>

    <b-form @submit.prevent="onSubmit">
      <b-form-input
        class="mt-3"
        v-model="comment"
        placeholder="Escreva o seu comentário aqui..."
      ></b-form-input>
    </b-form>
  </b-container>
</template>

<script>
import PostCommentComponent from "./PostCommentComponent.vue";
import PostOptionsComponent from "./PostOptionsComponent.vue";

import postService from "../services/postService";
import commentService from "../services/commentService";

import Post from "../models/post";
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
        }

        // if (res.status === 201) {
        //   let newComment = new Comment(res.data.data);

        //   this.post.comments.push(newComment);
        //   this.comment = "";
        // }
      }
    },

    onDeleted(deleteOptions) {
      if (deleteOptions.isPost) {
        this.$emit("on-post-deleted", deleteOptions.id);
      } else if (deleteOptions.isComment) {
        this.$emit("on-comment-deleted", deleteOptions.id);
      }
    },
  },
};
</script>
