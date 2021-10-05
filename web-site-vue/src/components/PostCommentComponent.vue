<template>
  <div>
    <b-card>
      <b-media>
        <template #aside>
          <b-img
            blank
            blank-color="#ccc"
            width="64"
            alt="placeholder"
            class="rounded"
          ></b-img>
        </template>

        <div id="commentOptionsDropdown">
          <b-dropdown
            class="float-right p-0"
            size="lg"
            variant="link"
            toggle-class="text-decoration-none"
            no-caret
          >
            <template #button-content>
              <b-icon
                class="float-right"
                style="color: black"
                icon="three-dots-vertical"
              ></b-icon>
            </template>
            <b-dropdown-item v-if="isUserComment">
              <b-icon class="mr-1" icon="search"></b-icon> Editar
            </b-dropdown-item>
            <b-dropdown-item
              ><b-icon class="mr-2" icon="file-check"></b-icon
              >Reportar</b-dropdown-item
            >
            <b-dropdown-item @click="onDeleteComment" v-if="isUserComment"
              ><b-icon class="mr-2" icon="trash"></b-icon
              ><span class="text-danger">Apagar</span></b-dropdown-item
            >
          </b-dropdown>
        </div>
        <h5
          class="font-weight-bold"
          :style="{ color: comment.user.userType.hexColorCode }"
        >
          {{ comment.user.name }}
        </h5>
        <p>
          {{ comment.description }}
        </p>
      </b-media>
    </b-card>
  </div>
</template>

<script>
import commentService from "../services/commentService";

import Comment from "../models/comment";

export default {
  name: "post-comment-component",
  props: {
    comment: Comment,
  },
  data() {
    return {
      isUserComment: false,
    };
  },
  mounted() {
    this.isUserComment =
      this.$store.getters["auth/user"].id === this.comment.user.id;
  },
  methods: {
    async onDeleteComment() {
      await commentService.deleteComment(this.comment.id);
      this.$emit("on-deleted-comment", this.comment.id);
    },
  },
};
</script>

<style>
#commentOptionsDropdown .dropdown-toggle {
  padding: 0 !important;
}
</style>