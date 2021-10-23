<template>
  <div>
    <b-container>
      <b-row>
        <b-col>
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

                <b-form-group
                  label="Insira o tipo de post:"
                  label-for="postType"
                >
                  <b-form-select
                    id="postType"
                    v-model="form.postTypeId"
                    :options="postTypesSelect"
                    required
                  ></b-form-select>
                </b-form-group>

                <b-form-group
                  label="Tagged input using select"
                  label-for="tags-component-select"
                >
                  <!-- Prop `add-on-change` is needed to enable adding tags vie the `change` event -->
                  <b-form-tags
                    id="tags-component-select"
                    v-model="form.tags"
                    size="lg"
                    class="mb-2"
                    :limit="limitTag"
                    add-on-change
                    no-outer-focus
                  >
                    <template
                      v-slot="{
                        tags,
                        inputAttrs,
                        inputHandlers,
                        disabled,
                        removeTag,
                      }"
                    >
                      <ul
                        v-if="tags.length > 0"
                        class="list-inline d-inline-block mb-2"
                      >
                        <li
                          v-for="tag in tags"
                          :key="tag"
                          class="list-inline-item"
                        >
                          <b-form-tag
                            @remove="removeTag(tag)"
                            :title="tag"
                            :disabled="disabled"
                            variant="primary"
                            class="text-white"
                            >{{ tag }}</b-form-tag
                          >
                        </li>
                      </ul>
                      <b-form-select
                        v-bind="inputAttrs"
                        v-on="inputHandlers"
                        :disabled="
                          disabled ||
                          availableOptions.length === 0 ||
                          form.tags.length >= 6
                        "
                        :options="availableOptions"
                      >
                        <template #first>
                          <!-- This is required to prevent bugs with Safari -->
                          <option disabled value="">Escolha uma tag...</option>
                        </template>
                      </b-form-select>
                    </template>
                  </b-form-tags>
                </b-form-group>
              </b-form>
            </b-modal>

            <b-dropdown class="ml-2" id="dropdown-1" :text="filterSelected">
              <b-dropdown-item disabled value="0"
                >Escolha o tipo de post</b-dropdown-item
              >
              <b-dropdown-item
                @click="onFilterClick(postType)"
                v-for="postType in postTypes"
                :key="postType.id"
              >
                {{ postType.name }}
              </b-dropdown-item>
            </b-dropdown>

            <b-icon
              v-if="filterMode"
              class="ml-2 align-middle text-danger"
              style="cursor: pointer"
              icon="x"
              font-scale="2"
              @click="onClearFilter"
            ></b-icon>
          </div>
        </b-col>
      </b-row>
      <b-row class="w-100">
        <b-col sm="9">
          <template v-if="posts.length > 0">
          <transition-group name="fade" tag="div">
            <div v-for="post in posts" :key="post.id">
              <post-component
                @on-post-deleted="onPostDeleted"
                @on-comment-deleted="onCommentDeleted"
                :post="post"
              ></post-component>
            </div>
          </transition-group>
          </template>
          <template v-else>
            <h5>Não há posts para mostrar.</h5>
          </template>
        </b-col>
        <b-col class="ml-4">
          <popularTags-component></popularTags-component>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import PostRequest from "../models/requests/postRequest";

import PostComponent from "../components/PostComponent.vue";
import PopularTagsComponent from "../components/PopularTagsComponent.vue";

import postService from "../services/postService";
import tagService from "../services/tagService";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import Post from "../models/post";

export default {
  name: "Post",
  components: { PostComponent, PopularTagsComponent },
  async mounted() {
    this.posts = await postService
      .getPosts()
      .catch((err) => console.log(err.response));

    this.posts = this.posts.filter(x => !x.suspended)
    this.originalPosts = this.posts;
    let postTypes = await postService.getPostTypes();

    this.postTypes = postTypes;

    this.postTypesSelect.push({ value: null, text: "Selecione uma opção" });
    let selectOptions = postTypes.map((x) => ({
      value: x.id,
      text: x.name,
    }));

    this.postTypesSelect = this.postTypesSelect.concat(selectOptions);

    let tags = await tagService.getTags();
    this.tags = tags;
    this.tagOptions = tags.map((t) => t.name).sort();

    this.$root.$on("tag-search-navbar", (tagIds) => {
      if (tagIds.length > 0) {
        this.posts = this.originalPosts.filter(p => p.tags.some(t => tagIds.includes(t.id)));
      } else {
        this.posts = this.originalPosts;
      }
    });
  },
  computed: {
    availableOptions() {
      return this.tagOptions.filter(
        (opt) => this.form.tags.indexOf(opt) === -1
      );
    },
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      form: {
        title: { required },
        description: { required },
        postTypeId: { required },
        userId: { required },
        suspended: { required },
        tags: { required },
      },
    };
  },
  data() {
    return {
      filterSelected: "Filtro",
      originalPosts: [],
      posts: [],
      tags: [],
      tagOptions: [],
      dismissSecs: 5,
      dismissCountDown: 0,
      postTypes: [],
      postTypesSelect: [],
      limitTag: 6,
      form: {
        title: "",
        description: "",
        postTypeId: null,
        userId: this.$store.getters["auth/user"].id,
        suspended: 0,
        tags: [],
      },
      filterMode: false,
    };
  },
  methods: {
    async createPost() {
      let tagIds = this.tags
        .filter((t) => this.form.tags.includes(t.name))
        .map((t) => t.id);

      let request = new PostRequest(
        null,
        this.form.title,
        this.form.description,
        this.form.suspended,
        this.form.userId,
        this.form.postTypeId,
        null,
        tagIds
      );

      let res = await postService.create(request).catch((err) => {
        this.$root.$emit("show-alert", {
          alertMessage: "Ocorreu um erro: " + err.response + ".",
          variant: "danger",
        });
      });

      let newPost = new Post(res.data.data);

      if (res.status === 201) {
        this.posts.unshift(newPost);
        this.$root.$emit("show-alert", {
          alertMessage: "Post criado com sucesso!",
          variant: "success",
        });
      }
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
      this.filterSelected = postType.name;
    },
    onClearFilter() {
      this.posts = this.originalPosts;
      this.filterSelected = "Filtro";
      this.filterMode = false;
    },
  },
};
</script>
