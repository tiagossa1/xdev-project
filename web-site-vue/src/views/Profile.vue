<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5" sm="3">
        <transition
          name="fade"
          enter-active-class="fadeInLeft"
          leave-active-class="fadeOutRight"
        >
          <user-card-component
            v-if="show"
            :userInfo="userInfo"
            :postCount="posts.length"
          ></user-card-component>
        </transition>
      </b-col>

      <b-col class="p-5" sm="6">
        <transition
          name="fade"
          enter-active-class="fadeInLeft"
          leave-active-class="fadeOutRight"
        >
          <b-tabs v-if="show" pills card class="bg-white">
            <b-tab class="bg-white" title="Posts" active>
              <div v-if="posts.length > 0">
                <div v-for="post in posts" :key="post.id">
                  <post-component
                    @on-post-deleted="onPostDeleted"
                    :post="post"
                  ></post-component>
                </div>
              </div>

              <div v-else>
                <h5 class="text-center">
                  Não criou nenhum post. Crie um usando o botão "Criar post" na
                  página inicial.
                </h5>
              </div>
            </b-tab>

            <b-tab v-if="!paramId" class="bg-white" title="Guardados">
              <div v-if="favoritePosts.length > 0">
                <div v-for="post in favoritePosts" :key="post.id">
                  <post-component
                    @on-unsaved="onUnsaved"
                    :post="post"
                  ></post-component>
                </div>
              </div>
              <div v-else>
                <h5 class="text-center">
                  Não há posts guardados. Guarde clicando no botão "Guardar" num
                  post.
                </h5>
              </div>
            </b-tab>
          </b-tabs>
        </transition>
      </b-col>

      <b-col
        v-if="recentFeed.comments.length > 0 || recentFeed.likes.length > 0"
        class="p-5"
        sm="3"
      >
        <transition
          name="fade"
          enter-active-class="fadeInLeft"
          leave-active-class="fadeOutRight"
        >
          <recent-feed v-if="show" :recentFeed="recentFeed"></recent-feed>
        </transition>
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
      show: false,
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

    this.show = true;
  },
  methods: {
    onPostDeleted(id) {
      this.posts = this.posts.filter((p) => p.id != id);
    },
    onUnsaved(postId) {
      const index = this.favoritePosts.findIndex((p) => p.id === postId);

      if (index > -1) {
        this.favoritePosts.splice(index, 1);
      }
    },
  },
};
</script>

<style>
</style>