<template>
  <div>
    <template v-if="notifications.length > 0">
      <b-table
        ref="notificationTable"
        table-variant="light"
        striped
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
            <b-button @click="onSuspendedPost(data.item)" variant="warning"
              >Suspender Post</b-button
            >
          </template>
          <template v-if="data.item.report.postComment !== null">
            <b-button @click="onDeleteComment(data.item)" variant="danger"
              >Eliminar Comentário</b-button
            >
          </template>
          <b-button class="ml-2 text-white" variant="primary"
            >Não fazer nada</b-button
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

import PostRequest from "../../models/requests/postRequest";
import ReportRequest from "../../models/requests/reportRequest";

import postService from "../../services/postService";
import reportConclusionService from "../../services/reportConclusionService";
import reportService from "../../services/reportService";
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
    async onSuspendedPost(item) {
      let reportConclusions = await reportConclusionService.get();
      let suspendedConclusion = reportConclusions.find((rc) =>
        rc.name.toLowerCase().includes("suspenso")
      );

      let postRequest = new PostRequest(
        item.report.post.id,
        item.report.post.title,
        item.report.post.description,
        true,
        item.report.post.user.id,
        item.report.post.postType.id
      );

      await postService.updatePost(postRequest).catch((err) => {
        this.$root.$emit("show-alert", {
          alertMessage: "Ocorreu um erro: " + err.response.data + ".",
          variant: "danger",
        });
      });

      let reportRequest = new ReportRequest(
        item.report.id,
        item.report.user.id,
        item.report.post.id,
        this.user.id,
        suspendedConclusion?.id ?? null,
        item.report?.comment?.id ?? null,
        true,
        item.report.reason,
        null
      );

      await reportService.update(reportRequest).catch((err) => {
        this.$root.$emit("show-alert", {
          alertMessage: "Ocorreu um erro: " + err.response.data + ".",
          variant: "danger",
        });
      });

      let notificationRes = await notificationService
        .markAsRead(item.id)
        .catch((err) => {
          this.$root.$emit("show-alert", {
            alertMessage: "Ocorreu um erro: " + err.response.data + ".",
            variant: "danger",
          });
        });

      if (notificationRes.status === 200) {
        // this.$emit("on-notification-deleted", item.id);
        const index = this.notifications.findIndex((n) => n.id === item.id);

        if (index >= 0) {
          this.notifications.splice(index, 1);
          this.$refs.notificationTable.refresh();
        }
        this.$root.$emit("show-alert", {
          alertMessage: "Post suspenso com sucesso!",
          variant: "success",
        });
      }
    },
    async onDeleteComment(item) {
      let res = await commentService
        .deleteComment(item.report.postComment.id)
        .catch((err) => {
          this.$root.$emit("show-alert", {
            alertMessage: "Ocorreu um erro: " + err.response.message + ".",
            variant: "danger",
          });
        });

      if (res.status === 200) {
        let notificationRes = await notificationService
          .markAsRead(item.id)
          .catch((err) => {
            this.$root.$emit("show-alert", {
              alertMessage: "Ocorreu um erro: " + err.response.data + ".",
              variant: "danger",
            });
          });

        if (notificationRes.status === 200) {
          const index = this.notifications.findIndex((n) => n.id === item.id);

          if (index >= 0) {
            this.notifications.splice(index, 1);
            this.$refs.notificationTable.refresh();
          }
          this.$root.$emit("show-alert", {
            alertMessage: "Comentário eliminado com sucesso.",
            variant: "success",
          });
        }
      }
    },
  },
};
</script>
