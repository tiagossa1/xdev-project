<template>
  <div class="container">
    <div class="buttons m-3">
      <b-button class="text-white" variant="primary" v-b-modal.modal-1
        >Criar Post</b-button
      >

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
              :options="postTypesSelect"
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

      <b-dropdown class="ml-2" id="dropdown-1" :text="filterSelected">
        <b-dropdown-item disabled value="0">Escolha o tipo de post</b-dropdown-item>
        <b-dropdown-item
          @click="onFilterClick(postType)"
          v-for="postType in postTypes"
          :key="postType.id"
        >
          {{  postType.name }}
        </b-dropdown-item>
      </b-dropdown>

      <b-button
        v-if="filterMode"
        class="ml-2"
        variant="success"
        @click="onClearFilter"
        >Limpar filtro
      </b-button>
    </div>

    <transition-group name="fade" tag="div">
      <div v-for="post in posts" :key="post.id">
        <post-component
          @on-post-deleted="onPostDeleted"
          @on-comment-deleted="onCommentDeleted"
          :post="post"
        ></post-component>
      </div>
    </transition-group>
  </div>
</template>

<script>
import PostComponent from "../components/PostComponent.vue";

import postService from "../services/postService";

export default {
  name: "Post",
  components: { PostComponent },
  async created() {
    this.posts = await postService.getPosts().catch(err => console.log(err.response));
    this.originalPosts = this.posts;

    let postTypes = await postService.getPostTypes();

    this.postTypes = postTypes;

    this.postTypesSelect.push({ value: null, text: "Selecione uma opção" });
    let selectOptions = postTypes.map((x) => ({
      value: x.id,
      text: x.name,
    }));

    this.postTypesSelect = this.postTypesSelect.concat(selectOptions);
  },
  data() {
    return {
      filterSelected: 'Filtro',

      originalPosts: [],
      posts: [],
      dismissSecs: 5,
      dismissCountDown: 0,
      postTypes: [],
      postTypesSelect: [],
      form: {
        title: "",
        description: "",
        post_type_id: null,
        user_id: this.$store.getters["auth/user"].id,
        suspended: 0,
      },
      filterMode: false,
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
    onFilterClick(postType) {
      this.filterMode = true;
      this.posts = this.originalPosts.filter(
        (p) => p.postType.id === postType.id
      );
      this.filterSelected = postType.name
    },
    onClearFilter() {
      this.posts = this.originalPosts;
      this.filterSelected = 'Filtro'
      this.filterMode = false;
    },
  },
};
</script>
