<template>
  <div>
    <b-container>
      <b-row>
        <b-col>
          <div class="buttons mt-3 mb-3">
            <transition
              name="fade"
              enter-active-class="fadeInLeft"
              leave-active-class="fadeOutRight"
            >
              <b-button
                v-if="show"
                class="text-white"
                variant="primary"
                v-b-modal.post-modal
                >Criar Post</b-button
              >
            </transition>

            <b-modal
              class="w-75"
              id="post-modal"
              title="Criar Post"
              size="lg"
              @ok="createPost"
            >
              <b-form ref="postInput">
                <b-form-group label="Insira o titulo:" label-for="textTitle">
                  <b-form-input
                    id="textTitle"
                    type="email"
                    v-model="form.title"
                    placeholder="Insira o titulo"
                    :state="!v$.form.title.$invalid"
                    @blur="v$.form.title.$touch"
                  ></b-form-input>
                </b-form-group>

                <b-form-group label="Insira a descrição:" label-for="textarea">
                  <quill-editor
                    ref="myQuillEditor"
                    v-model="form.description"
                    size="10"
                    @blur="v$.form.description.$touch"
                  >
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
                    :state="!v$.form.postTypeId.$invalid"
                    @blur="v$.form.postTypeId.$touch"
                  ></b-form-select>
                </b-form-group>

                <b-form-group
                  label="Insira as tags do post:"
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

            <transition
              name="fade"
              enter-active-class="fadeInLeft"
              leave-active-class="fadeOutRight"
            >
              <b-dropdown
                v-if="show"
                class="ml-2"
                id="dropdown-1"
                :text="filterSelected"
              >
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
            </transition>

            <transition
              name="fade"
              enter-active-class="fadeInLeft"
              leave-active-class="fadeOutRight"
            >
              <b-icon
                v-if="filterMode"
                class="ml-2 align-middle text-danger"
                style="cursor: pointer"
                icon="x"
                font-scale="2"
                @click="onClearFilter"
              ></b-icon>
            </transition>
          </div>
        </b-col>
      </b-row>
      <b-row class="w-100">
        <b-col sm="9">
          <template v-if="posts.length > 0">
            <transition-group name="fadeRight" tag="div">
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
          <transition
            name="fade"
            enter-active-class="fadeInLeft"
            leave-active-class="fadeOutRight"
          >
            <popular-tags-component v-if="show"></popular-tags-component>
          </transition>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Post from "../models/post";
import PostRequest from "../models/requests/postRequest";

import PostComponent from "../components/PostComponent.vue";
import PopularTagsComponent from "../components/PopularTagsComponent.vue";

import postService from "../services/postService";
import tagService from "../services/tagService";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "Post",
  components: { PostComponent, PopularTagsComponent },
  async mounted() {
    const isAuthenticated = this.$store.getters["auth/authenticated"];

    if (isAuthenticated) {
      this.posts = await postService.getPostsBySuspended(0).catch((err) => {
        let error;

        if (err.response.data.errors) {
          error = Object.values(err.response.data.errors)
            .map((v) => v.join(", "))
            .join(", ");
        }

        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: error ?? err.response.data.message,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });

      this.originalPosts = this.posts;
      let postTypes = await postService.getPostTypes();

      this.postTypes = postTypes;

      this.postTypesSelect.push({
        value: null,
        text: "Selecione uma opção",
        disabled: true,
      });
      let selectOptions = postTypes.map((x) => ({
        value: x.id,
        text: x.name,
      }));

      this.postTypesSelect = this.postTypesSelect.concat(selectOptions);

      let tags = await tagService.getTags();
      this.tags = tags;
      this.tagOptions = tags.map((t) => t.name).sort();

      this.$root.$on("tag-search-navbar", (tagIds) => {
        this.onClearFilter();

        if (tagIds.length > 0) {
          this.posts = this.originalPosts.filter((p) =>
            p.tags.some((t) => tagIds.includes(t.id))
          );
        } else {
          this.posts = this.originalPosts;
        }
      });

      this.show = true;
    }
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
      },
    };
  },
  data() {
    return {
      form: {
        title: null,
        description: null,
        postTypeId: null,
        userId: this.$store.getters["auth/user"].id,
        suspended: 0,
        tags: [],
      },
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
      show: false,
      filterMode: false,
    };
  },
  methods: {
    async createPost(bvModalEvt) {
      if (!this.v$.form.$invalid) {
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
          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors)
              .map((v) => v.join(", "))
              .join(", ");
          }

          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: error ?? err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });

          this.form.title = this.form.description = this.form.postTypeId = "";
          this.form.postTypeId = null;
          this.form.tags = [];
        });

        let newPost = new Post(res.data.data);

        if (res.status === 201) {
          this.posts.unshift(newPost);
          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Post criado.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        }

        this.form.title = this.form.description = this.form.postTypeId = "";
        this.form.postTypeId = null;
        this.form.tags = [];
      } else {
        bvModalEvt.preventDefault();
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
      this.$root.$emit("navbar-clear-filter", true);

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
