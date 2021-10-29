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
      this.$swal({
        title: "Confirmação",
        text: "Deseja mesmo suspender o post?",
        showCancelButton: true,
        confirmButtonText: "Suspender",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
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

          await postService.update(postRequest).catch((err) => {
<<<<<<< Updated upstream
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
=======
            this.$swal({
              icon: "error",
              position: "bottom-right",
              title: err.response.data,
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 3500,
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
            this.$swal({
              icon: "error",
              position: "bottom-right",
              title: err.response.data,
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 3500,
>>>>>>> Stashed changes
            });
          });

          let notificationRes = await notificationService
            .markAsRead(item.id)
            .catch((err) => {
<<<<<<< Updated upstream
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

          if (notificationRes.status === 200) {
            // this.$emit("on-notification-deleted", item.id);
            const index = this.notifications.findIndex((n) => n.id === item.id);

=======
              this.$swal({
                icon: "error",
                position: "bottom-right",
                title: err.response.data,
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
                timer: 3500,
              });
            });

          if (notificationRes.status === 200) {
            // this.$emit("on-notification-deleted", item.id);
            const index = this.notifications.findIndex((n) => n.id === item.id);

>>>>>>> Stashed changes
            if (index >= 0) {
              this.notifications.splice(index, 1);
              this.$refs.notificationTable.refresh();
            }
            this.$swal({
              icon: "success",
              position: "bottom-right",
              title: "Post suspenso.",
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
<<<<<<< Updated upstream
              timer: 10000,
=======
              timer: 3500,
>>>>>>> Stashed changes
            });
          }
        }
      });
    },
    async onDeleteComment(item) {
      this.$swal({
        title: "Confirmação",
        text: "Deseja mesmo apagar o comentário?",
        showCancelButton: true,
        confirmButtonText: "Apagar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
          let res = await commentService
            .deleteComment(item.report.postComment.id)
            .catch((err) => {
<<<<<<< Updated upstream
              let error;

              if (err.response.data.errors) {
                error = Object.values(err.response.data.errors)
                  .map((v) => v.join(", "))
                  .join(", ");
              }

              this.$swal({
                icon: "error",
                position: "bottom-right",
                title: error ?? err.response.message,
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
                timer: 10000,
              });
            });

          if (res.status === 200) {
            let notificationRes = await notificationService
              .markAsRead(item.id)
              .catch((err) => {
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

            if (notificationRes.status === 200) {
              const index = this.notifications.findIndex(
                (n) => n.id === item.id
              );

              if (index >= 0) {
                this.notifications.splice(index, 1);
                this.$refs.notificationTable.refresh();
              }

=======
              this.$swal({
                icon: "error",
                position: "bottom-right",
                title: err.response.message,
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
                timer: 3500,
              });
            });

          if (res.status === 200) {
            let notificationRes = await notificationService
              .markAsRead(item.id)
              .catch((err) => {
                this.$swal({
                  icon: "error",
                  position: "bottom-right",
                  title: err.response.data,
                  toast: true,
                  showCloseButton: true,
                  showConfirmButton: false,
                  timer: 3500,
                });
              });

            if (notificationRes.status === 200) {
              const index = this.notifications.findIndex(
                (n) => n.id === item.id
              );

              if (index >= 0) {
                this.notifications.splice(index, 1);
                this.$refs.notificationTable.refresh();
              }

>>>>>>> Stashed changes
              this.$swal({
                icon: "success",
                position: "bottom-right",
                title: "Notificação criada.",
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
<<<<<<< Updated upstream
                timer: 10000,
=======
                timer: 3500,
>>>>>>> Stashed changes
              });
            }
          }
        }
      });
    },
    async onDoNothing() {
      this.$swal({
        title: "Confirmação",
        text: "Tem a certeza que não quer tomar nenhuma medida sobre este report?",
        showCancelButton: true,
        confirmButtonText: "Não",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      });
    },
  },
};
</script>
