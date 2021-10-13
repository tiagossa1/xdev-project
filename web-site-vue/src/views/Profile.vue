<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5">
        <user-card-component :userInfo="userInfo"></user-card-component>
      </b-col>

      <b-col class="p-5">
        <div v-for="post in posts" :key="post.id">
          <post-component :post="post"></post-component>
        </div>
      </b-col>

      <b-col> </b-col>
    </b-row>
  </b-container>
</template>

<script>
import userService from "../services/userService";
import postService from "../services/postService";

import UserCardComponent from "../components/UserCardComponent.vue";
import PostComponent from "../components/PostComponent.vue";

import User from "../models/user";
import Post from "../models/post";
export default {
  name: "Profile",
  components: { UserCardComponent, PostComponent },
  data() {
    return {
      userInfo: User,
      posts: Post,
    };
  },
  async mounted() {
    const paramId = this.$route.params.id;

    if (paramId) {
      this.userInfo = await userService.getUserById(paramId);
      this.posts = await postService.getPostsByUser(paramId);
    } else {
      this.userInfo = await userService.getUserById(
        this.$store.getters["auth/user"].id
      );

      this.posts = await postService.getPostsByUser(
        this.$store.getters["auth/user"].id
      );
    }
  },
};
</script>

<style>
</style>