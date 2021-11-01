<template>
  <div>
    <h5 class="mb-3 font-weight-bold">Gestão de reports</h5>
    <template v-if="reports.length > 0">
      <b-table
        ref="reportsTable"
        striped
        sticky-header="500px"
        bordered
        borderless
        outlined
        table-variant="light"
        :items="reports"
        :fields="tableFields"
      >
        <template #cell(user)="data">
          <b-link target="_blank" :to="'/profile/' + data.item.user.id">
            {{ data.item.user.name }} ({{ data.item.user.email }})</b-link
          >
        </template>
        <template #cell(post)="data">
          <template v-if="data.item.post">
            <a
              v-b-modal.post-modal
              :ref="data.item.post.title"
              target="_blank"
              href=""
              @click.prevent="setPost(data.item.post)"
              >{{ data.item.post.title }}</a
            >
          </template>
          <template v-else>
            Não foi reportado nenhum post.
          </template>
        </template>
        <template #cell(postComment)="data">
          <template v-if="data.item.postComment">
            <span class="font-italic"
              >"{{ data.item.postComment.description }}"</span
            >
            por
            <b-link
              target="_blank"
              :to="'/profile/' + data.item.postComment.user.id"
            >
              {{ data.item.postComment.user.name }} ({{
                data.item.postComment.user.email
              }})</b-link
            >
          </template>
          <template v-else> Não foi reportado nenhum comentário. </template>
        </template>
        <template #cell(actions)="data">
          <template v-if="data.item.post !== null">
            <b-button @click="onSuspendedPost(data.item)" variant="danger"
              >Suspender</b-button
            >
          </template>
          <template v-else-if="data.item.postComment !== null">
            <b-button @click="onDeleteComment(data.item)" variant="danger"
              >Eliminar</b-button
            >
          </template>
          <b-button
            @click="onDoNothing(data.item)"
            class="text-white"
            variant="primary"
            >Sem ação</b-button
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
    <template v-else> Sem reports. </template>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import reportService from "../../services/reportService";
import postService from "../../services/postService";
import commentService from "../../services/commentService";
import reportConclusionService from "../../services/reportConclusionService";

import PostRequest from "../../models/requests/postRequest";
import ReportRequest from "../../models/requests/reportRequest";

import PostComponent from "../PostComponent.vue";

export default {
  name: "report-management-component",
  data() {
    return {
      tableFields: [
        { key: "user", label: "Reportado por" },
        { key: "post", label: "Post reportado" },
        { key: "postComment", label: "Comentário reportado" },
        { key: "reason", label: "Razao" },
        { key: "createdAt", label: "Data de criação" },
        { key: "actions", label: "Ações" },
      ],
      reports: [],
      postSelected: null,
    };
  },
  components: { PostComponent },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
  },
  async mounted() {
    this.reports = await reportService.getOpenReports();
  },
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
          let postRequest = new PostRequest(
            item.post.id,
            item.post.title,
            item.post.description,
            true,
            item.post.user.id,
            item.post.postType.id
          );

          await postService.update(postRequest).catch((err) => {
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

          let suspendedConclusion = await reportConclusionService.getByName(
            "suspenso"
          );

          if (suspendedConclusion?.length === 0) {
            this.$swal({
              icon: "error",
              position: "bottom-right",
              title:
                "Não existe nenhuma conclusão para suspender um post. Por favor, contacte um xMod.",
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000,
            });
            return;
          }

          let reportRequest = new ReportRequest(
            item.id,
            item.user.id,
            item.post?.id,
            this.user.id,
            suspendedConclusion[0]?.id ?? null,
            item.comment?.id ?? null,
            true,
            item.reason,
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
            });
          });

          const index = this.reports.findIndex((n) => n.id === item.id);

          if (index >= 0) {
            this.reports.splice(index, 1);
            this.$refs.reportsTable.refresh();
          }

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Post suspenso.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });
        }
      });
    },
    async onDeleteComment(item) {
      this.$swal({
        title: "Confirmação",
        text: "Deseja mesmo eliminar o comentário?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
          let res = await commentService
            .delete(item.postComment.id)
            .catch((err) => {
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
            let conclusionDeleted = await reportConclusionService.getByName(
              "eliminado"
            );

            if (conclusionDeleted?.length === 0) {
              this.$swal({
                icon: "error",
                position: "bottom-right",
                title:
                  "Não existe nenhuma conclusão para eliminar um comentário. Por favor, contacte um xMod.",
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
                timer: 10000,
              });
              return;
            }

            let reportRequest = new ReportRequest(
              item.id,
              item.user.id,
              item.post?.id,
              this.user.id,
              conclusionDeleted[0]?.id ?? null,
              item.postComment?.id ?? null,
              true,
              item.reason,
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
              });
            });

            if (res.status === 200) {
              const index = this.reports.findIndex((n) => n.id === item.id);

              if (index >= 0) {
                this.reports.splice(index, 1);
                this.$refs.reportsTable.refresh();
              }

              this.$swal({
                icon: "success",
                position: "bottom-right",
                title: "Comentário eliminado.",
                toast: true,
                showCloseButton: true,
                showConfirmButton: false,
                timer: 3500,
              });
            }
          }
        }
      });
    },
    async onDoNothing(item) {
      this.$swal({
        title: "Confirmação",
        text:
          "Tem a certeza que não quer tomar nenhuma medida sobre este report?",
        showCancelButton: true,
        confirmButtonText: "Não",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
          let noFurtherActionTaken = await reportConclusionService.getByName(
            "sem medidas"
          );

          if (noFurtherActionTaken?.length === 0) {
            this.$swal({
              icon: "error",
              position: "bottom-right",
              title:
                "Não existe nenhuma conclusão para um report sem nehuma medida. Por favor, contacte um xMod.",
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000,
            });
            return;
          }

          let reportRequest = new ReportRequest(
            item.id,
            item.user.id,
            item.post?.id,
            this.user.id,
            noFurtherActionTaken[0].id ?? null,
            item.postComment?.id ?? null,
            true,
            item.reason,
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
            });
          });

          const index = this.reports.findIndex((n) => n.id === item.id);

          if (index >= 0) {
            this.reports.splice(index, 1);
            this.$refs.reportsTable.refresh();
          }

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Report fechado sem nenhuma medida tomada.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });
        }
      });
    },
  },
};
</script>
