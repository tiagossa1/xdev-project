<template>
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
    <b-dropdown-item @click="onEdit" v-if="isUserOwner">
      <b-icon class="mr-1" icon="pencil"></b-icon> Editar
    </b-dropdown-item>
    <b-dropdown-item @click="openReportModal" v-if="!isUserOwner"
      ><b-icon class="mr-2" icon="file-check"></b-icon>Reportar</b-dropdown-item
    >
    <b-dropdown-item @click="onDelete" v-if="isUserOwner"
      ><b-icon class="mr-2" icon="trash"></b-icon
      ><span class="text-danger">Apagar</span></b-dropdown-item
    >
    <b-modal @ok="onOkReportModal" ref="modal-report" :title="reportTitle">
      <b-form-textarea
        v-model="reportComment"
        rows="5"
        max-rows="10"
        :placeholder="reportPlaceholder"
      ></b-form-textarea>
    </b-modal>
  </b-dropdown>
</template>

<script>
import postService from "../services/postService";
import commentService from "../services/commentService";
import reportService from "../services/reportService";

import Post from "../models/post";
import Comment from "../models/comment";
import ReportRequest from "../models/requests/reportRequest";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "post-options-component",
  props: {
    post: Post,
    comment: Comment,
  },
  created() {
    if (this.post) {
      this.isUserOwner =
        this.post.user.id === this.$store.getters["auth/user"].id;
      this.reportTitle = "Reportar post";
      this.reportPlaceholder =
        "Escreva o motivo pela qual pretende reportar o post...";
    } else if (this.comment) {
      this.isUserOwner =
        this.comment.user.id === this.$store.getters["auth/user"].id;
      this.reportTitle = "Reportar comentário";
      this.reportPlaceholder =
        "Escreva o motivo pela qual pretende reportar o comentário...";
    }
  },
  data() {
    return {
      isUserOwner: false,
      reportComment: "",
      reportTitle: "",
      reportPlaceholder: "",
    };
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      reportComment: { required },
    };
  },
  methods: {
    openReportModal() {
      this.$refs["modal-report"].show();
    },
    async onDelete() {
      let eventBody = {};

      if (this.post) {
        let res = await postService.delete(this.post.id);

        if (res.status === 200) {
          eventBody = { isPost: true, id: this.post.id };
        }
      } else if (this.comment) {
        let res = await commentService.delete(this.comment.id);

        if (res.status === 200) {
          eventBody = { isComment: true, id: this.comment.id };
        }
      }

      this.$emit("on-deleted", eventBody);
    },
    async onOkReportModal(bvModalEvt) {
      bvModalEvt.preventDefault();

      let request = {};
      let okRequest = false;
      let alertMsg = "";

      if (!this.v$.$invalid) {
        if (this.post) {
          request = new ReportRequest(
            null,
            this.$store.getters["auth/user"].id,
            this.post.id,
            null,
            null,
            null,
            false,
            this.reportComment,
            null
          );
        } else if (this.comment) {
          request = new ReportRequest(
            null,
            this.$store.getters["auth/user"].id,
            null,
            null,
            null,
            this.comment.id,
            false,
            this.reportComment,
            null
          );
        }

        let res = await reportService.create(request).catch((err) => {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: err.response.data,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

        okRequest = res.status === 201;

        if (okRequest) {
          if (this.post) {
            alertMsg = "Post reportado.";
          } else if (this.comment) {
            alertMsg = "Comentário reportado.";
          }
        } else {
          alertMsg = "Ocorreu um erro";
        }

        this.$swal({
          icon: okRequest ? "success" : "error",
          position: "bottom-right",
          title: alertMsg,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });

        this.$refs["modal-report"].hide();
      }
    },
    onEdit() {
      this.$emit("on-edit", true);
    },
  },
};
</script>
