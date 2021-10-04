<template>
  <b-container
    :style="{ border: '2px solid gray', 'border-radius': '25px' }"
    class="bv-example-row p-4 ml-4 mb-4"
  >
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
        <!--Usar Pill-->
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
      <b-col style="cursor: pointer" @click="onLike">
        <p class="h5">
          <b-icon
            :icon="liked ? 'heart-fill' : 'heart'"
            :variant="liked ? 'liked' : ''"
            >Like</b-icon
          >
          Like
        </p>
      </b-col>
      <b-col style="cursor: pointer">
        <p class="h5">
          <b-icon icon="chat-left">chat-left</b-icon>
          Comentar
        </p>
      </b-col>
      <b-col style="cursor: pointer">
        <p class="h5">
          <b-icon
            :variant="saved ? 'danger' : ''"
            :icon="saved ? 'bookmark-fill' : 'bookmark'"
            >Bookmark</b-icon
          >
          Guardar
        </p>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import postService from "../services/postService";
import Post from "../models/post";

export default {
  name: "post-component",
  props: {
    post: Post,
  },
  mounted() {
    // console.log(this.post);
  },
  data() {
    return {
      liked: this.post.userLikes.includes(this.$store.getters["auth/user"].id),
      saved: false,
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
  },
};
</script>
