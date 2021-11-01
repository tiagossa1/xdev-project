<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5" sm="3">
        <transition
          name="fade"
          enter-active-class="fadeIn"
          leave-active-class="fadeOut"
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
          enter-active-class="fadeIn"
          leave-active-class="fadeOut"
        >
          <b-tabs
            v-if="show"
            pills
            card
            class="bg-white card-rounded"
          >
            <b-tab
              class="bg-white card-rounded"
              title="Posts"
              active
            >
              <div v-if="posts.length > 0">
                <div v-for="post in posts" :key="post.id">
                  <post-component
                    @on-post-deleted="onPostDeleted"
                    @on-comment-deleted="onCommentDelete"
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
                    @on-comment-deleted="onFavoritePostsCommentDelete"
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
          enter-active-class="fadeIn"
          leave-active-class="fadeOut"
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
    onCommentDelete(id) {
      let post = this.posts.find((x) => x.comments.some((c) => c.id === id));

      if (post) {
        post.comments = post.comments.filter((c) => c.id != id);
        this.posts.find((x) => x.id === post.id).comments = post.comments;
      }
    },
    onFavoritePostsCommentDelete(id) {
      let post = this.favoritePosts.find((x) =>
        x.comments.some((c) => c.id === id)
      );

      if (post) {
        post.comments = post.comments.filter((c) => c.id != id);
        this.favoritePosts.find((x) => x.id === post.id).comments =
          post.comments;
      }
    },
  },
};
</script>

<style>
.card-rounded {
  border-radius: 10px;
}
</style>
