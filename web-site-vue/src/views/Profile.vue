<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5" sm="3">
        <user-card-component :userInfo="userInfo"></user-card-component>
      </b-col>

      <b-col class="p-5" sm="6" v-if="posts.length > 0">
        <div v-for="post in posts" :key="post.id">
          <post-component :post="post"></post-component>
        </div>
      </b-col>

      <b-col class="p-5" sm="6" v-else>
        <span>Não tem posts</span>
      </b-col>

      <b-col class="p-5" sm="3">
        <recent-feed :recentFeed="recentFeed"></recent-feed>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import userService from "../services/userService";
import postService from "../services/postService";

import UserCardComponent from "../components/UserCardComponent.vue";
import PostComponent from "../components/PostComponent.vue";
import RecentFeed from "../components/RecentFeedComponent.vue";

import Post from "../models/post";
export default {
  name: "Profile",
  components: {
    UserCardComponent,
    PostComponent,
    RecentFeed,
  },
  data() {
    return {
      getSuspendedPosts: {},
      userInfo: {
        userType: {},
        schoolClass: { school: {} },
        posts: {},
        tags: {},
      },
      recentFeed: { comments: [], likes: [] },
      posts: Post,
    };
  },
  async created() {
    const paramId = this.$route.params.id;

    if (paramId) {
      this.recentFeed = await userService.getRecentFeed(paramId);

      this.userInfo = await userService.getUserById(paramId);
      this.posts = await postService.getPostsByUser(paramId);

      this.posts = this.posts.filter((x) => !x.suspended);
    } else {
      this.recentFeed = await userService.getRecentFeed(
        this.$store.getters["auth/user"].id
      );
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