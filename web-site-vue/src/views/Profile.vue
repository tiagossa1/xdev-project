<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5" sm="3">
        <user-card-component
          :userInfo="userInfo"
          :postCount="posts.length"
        ></user-card-component>
      </b-col>

      <b-col class="p-5" sm="6">
        <b-tabs content-class="mt-3">
          <b-tab title="Posts" active>
            <div v-if="posts.length > 0">
              <div v-for="post in posts" :key="post.id">
                <post-component
                  @on-post-deleted="onPostDeleted"
                  :post="post"
                ></post-component>
              </div>
            </div>

            <div v-else>
              <span>Não tem posts</span>
            </div>
          </b-tab>

          <b-tab v-if="!paramId" title="Guardados">
            <div v-if="favoritePosts.length > 0">
              <div v-for="post in favoritePosts" :key="post.id">
                <post-component :post="post"></post-component>
              </div>
            </div>
            <div v-else>
              <h2 class="text-center">Não tem posts guardados</h2>
            </div>
          </b-tab>
        </b-tabs>
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
      paramId: null,
      userInfo: {
        userType: {},
        schoolClass: { school: {} },
        posts: {},
        tags: {},
      },
      favoritePosts: Post,
      recentFeed: { comments: [], likes: [] },
      posts: Post,
    };
  },
  async created() {
    this.paramId = this.$route.params.id;

    if (this.paramId) {
      this.recentFeed = await userService.getRecentFeed(this.paramId);

      this.userInfo = await userService.getUserById(this.paramId);
      this.posts = await postService.getPostsByUser(this.paramId);
      this.posts = this.posts.filter((x) => !x.suspended);

      this.favoritePosts = await userService.getFavoritePosts(this.paramId);
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

      this.favoritePosts = await userService.getFavoritePosts(
        this.$store.getters["auth/user"].id
      );
    }
  },
  methods: {
    onPostDeleted(id) {
      this.posts = this.posts.filter((p) => p.id != id);
    },
  },
};
</script>

<style>
</style>