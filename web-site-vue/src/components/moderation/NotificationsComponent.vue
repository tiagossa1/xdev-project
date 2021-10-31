<template>
  <div>
    <template v-if="notifications.length > 0">
      <b-table
        ref="notificationTable"
        table-variant="light"
        striped
        bordered
        borderless
        outlined
        :fields="fields"
        :items="notifications"
      >
        <template #cell(username)="data">
          <a target="_blank" :href="'/profile/' + data.item.report.user.id">
            {{ data.item.report.user.name }} ({{ data.item.report.user.email }})
          </a>
        </template>
        <template #cell(postTitle)="data">
          <template v-if="data.item.report.post">
            <a
              v-b-modal.post-modal
              :ref="data.item.report.post.title"
              target="_blank"
              href=""
              @click.prevent="setPost(data.item.report.post)"
              >{{ data.item.report.post.title }}</a
            >
          </template>
          <template v-else> Não foi reportado um post. </template>
        </template>
        <template #cell(commentTitle)="data">
          <template v-if="data.item.report.postComment">
            <span class="font-italic">{{
              data.item.report.postComment.description
            }}</span>
          </template>
          <template v-else> Não foi reportado um comentário. </template>
        </template>
        <template #cell(reason)="data">
          {{ data.item.report.reason }}
        </template>
        <template #cell(actions)="data">
          <template v-if="data.item.report.post !== null">
            <b-button @click="onSuspendedPost(data.item)" variant="danger"
              >Suspender Post</b-button
            >
          </template>
          <template v-if="data.item.report.postComment !== null">
            <b-button @click="onDeleteComment(data.item)" variant="danger"
              >Eliminar Comentário</b-button
            >
          </template>
          <b-button
            @click="onDoNothing(data.item)"
            class="ml-2 text-white"
            variant="primary"
            >Fechar sem ação</b-button
          >
        </template>
      </b-table>

      <b-modal id="post-modal" size="xl" title="Post reportado">
        <post-component
          class="w-75 m-auto"
          :post="postSelected"
          :viewOnly="true"
        ></post-component>
      </b-modal>
    </template>
    <template v-else> Não tem notificações. </template>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import notificationService from "../../services/notificationService";
import commentService from "../../services/commentService";

import PostComponent from "../PostComponent.vue";

export default {
  name: "notifications-component",
  props: { notifications: [] },
  data() {
    return {
      fields: [
        {
          key: "username",
          label: "Reportado por",
        },
        {
          key: "postTitle",
          label: "Post reportado",
        },
        {
          key: "commentTitle",
          label: "Comentário reportado",
        },
        {
          key: "reason",
          label: "Razão",
        },
        {
          key: "actions",
          label: "Ações",
        },
      ],
      postSelected: null,
    };
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  components: { PostComponent },
  mounted() {},
  methods: {
    setPost(post) {
      this.postSelected = post;
    },

  },
};
</script>
