<template>
  <div class="container">
    <div class="buttons m-3">
      <b-button pill variant="primary" v-b-modal.modal-1>Criar +</b-button>
      <b-modal
        class="w-75"
        id="modal-1"
        title="Criar Post"
        size="lg"
        @ok="createPost"
      >
        <b-form>
          <b-form-group label="Insira o titulo:" label-for="textTitle">
            <b-form-input
              id="textTitle"
              type="email"
              v-model="form.title"
              placeholder="Insira o titulo"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Insira a descrição:" label-for="textarea">
            <quill-editor ref="myQuillEditor" v-model="form.description">
            </quill-editor>
          </b-form-group>

          <b-form-group label="Insira o tipo de post:" label-for="postType">
            <b-form-select
              id="postType"
              v-model="form.post_type_id"
              :options="postTypes"
              :value="null"
              required
            ></b-form-select>
          </b-form-group>

          <b-form-group label="Insira as tags do post:" label-for="postTags">
            <b-form-tags
              id="postTags"
              v-model="postTags.tag_id"
              separator=" "
              required
            ></b-form-tags>

            <template #invalid-feedback>
              Tem de introduzir pelo menos 1 tag e no máximo 6.
            </template>

            <template #description>
              <div id="tags-validation-help">
                Os posts têm de ter pelo menos 1 tag e no máximo 6.
              </div>
            </template>
          </b-form-group>
        </b-form>
      </b-modal>

      <b-dropdown class="ml-2" id="dropdown-1" text="Filtro">
        <b-dropdown-item>First Action</b-dropdown-item>
      </b-dropdown>
    </div>

    <div v-for="post in posts" :key="post.id">
      <post-component
        @on-post-deleted="onPostDeleted"
        @on-comment-deleted="onCommentDeleted"
        :post="post"
      ></post-component>
    </div>
  </div>
</template>

<script>
import PostComponent from "../components/PostComponent.vue";

import postService from "../services/postService";

export default {
  name: "Post",
  components: { PostComponent },
  async created() {
    this.posts = await postService.getPosts();

    let postTypes = await postService.getPostTypes();
    this.postTypes = postTypes.map((x) => ({ value: x.id, text: x.name }));
  },
  data() {
    return {
      posts: [],
      dismissSecs: 5,
      dismissCountDown: 0,
      postTypes: [],
      form: {
        title: "",
        description: "",
        post_type_id: "",
        user_id: this.$store.getters["auth/user"].id,
        suspended: 0,
      },
      postTags: [
        {
          tag_id: "",
        },
      ],
    };
  },
  methods: {
    createPost() {
      console.log(this.form);
    },
    onPostDeleted(id) {
      this.posts = this.posts.filter((p) => p.id != id);
    },
    onCommentDeleted(id) {
      let post = this.posts.find((x) => x.comments.some((c) => c.id === id));

      if (post) {
        post.comments = post.comments.filter((c) => c.id != id);
        this.posts.find((x) => x.id === post.id).comments = post.comments;
      }
    },
  },
};
</script>
