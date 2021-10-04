<template>
  <div class="container">
    <post-options-component></post-options-component>

    <div v-for="post in posts" :key="post.id">
      <post-component :post="post"></post-component>
    </div>
  </div>
</template>

<script>
import PostComponent from "../components/PostComponent.vue";
import PostOptionsComponent from "../components/PostOptionsComponent.vue";
import postService from "../services/postService";

export default {
  name: "Post",
  components: { PostComponent, PostOptionsComponent },
  data() {
    return {
      posts: [],
    };
  },
  async created() {
    this.posts = await postService.getPosts();
  },
};
</script>
