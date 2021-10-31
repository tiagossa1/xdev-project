<template>
  <div>
    <b-card :style="{ borderRadius: '10px', border: '1px solid gray' }">
      <b-media>
        <template #aside>
          <b-avatar
            size="4rem"
            :to="'/profile/' + comment.user.id"
            :src="comment.user.profile_picture"
          ></b-avatar>
        </template>

        <div id="commentOptionsDropdown">
          <post-options-component
            v-if="!viewOnly"
            @on-deleted="onDeleted"
            @on-edit="onEdit"
            :comment="comment"
          ></post-options-component>
        </div>
        <b-modal
          @ok="onOkReportModal"
          ref="modal-report"
          title="Report comentário"
        >
          <b-form-textarea
            v-model="reportComment"
            rows="5"
            max-rows="10"
            placeholder="Escreva o motivo pela qual pretende reportar o comentário... (opcional)"
            :state="!v$.reportComment.$invalid"
            @blur="v$.reportComment.$touch"
          ></b-form-textarea>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.reportComment.required.$invalid"
          >
            Por favor, escreva uma razão.
            <br />
          </div>
        </b-modal>
        <b-link
          class="h5 font-weight-bold"
          :style="{ color: comment.user.userType.hexColorCode }"
          :to="'/profile/' + comment.user.id"
          >{{ comment.user.name }}</b-link
        >
        <template v-if="!toEdit">
          <p>
            {{ comment.description }}
          </p>
        </template>
        <template v-else>
          <b-container>
            <b-row>
              <b-col class="pl-0 pr-0" cols="10">
                <b-form-input
                  v-model="comment.description"
                  placeholder="Escreva o seu comentário..."
                  required
                ></b-form-input>
              </b-col>
              <b-col
                class="align-self-center"
                style="cursor: pointer"
                @click="onEdited"
              >
                <b-icon-pencil></b-icon-pencil>
              </b-col>
            </b-row>
          </b-container>
        </template>
      </b-media>
    </b-card>
  </div>
</template>

<script>
import reportService from "../services/reportService";
import commentService from "../services/commentService";

import Comment from "../models/comment";
import ReportRequest from "../models/requests/reportRequest";
import CommentRequest from "../models/requests/commentRequest";

import PostOptionsComponent from "../components/PostOptionsComponent";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "post-comment-component",
  components: { PostOptionsComponent },
  props: {
    postId: Number,
    comment: Comment,
    viewOnly: {
      default: false,
      type: Boolean,
    },
  },
  data() {
    return {
      isUserComment: false,
      reportComment: "",
      toEdit: false,
    };
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      reportComment: { required },
    };
  },
  mounted() {
    this.isUserComment =
      this.$store.getters["auth/user"].id === this.comment.user.id;
  },
  methods: {
    async onDeleted(deleteOptions) {
      // passing the event to the upper component.
      this.$emit("on-deleted", deleteOptions);
    },
    openReportModal() {
      this.$refs["modal-report"].show();
    },
    async onOkReportModal(bvModalEvt) {
      bvModalEvt.preventDefault();

      if (!this.v$.$invalid) {
        let request = new ReportRequest(
          this.$store.getters["auth/user"].id,
          null,
          null,
          null,
          this.comment.id,
          false,
          this.reportComment,
          null
        );

        let res = await reportService.create(request).catch((err) => {
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
          this.$emit("on-reported", {
            alertMessage: "Comentário reportado.",
            variant: "success",
          });
        }

        this.$refs["modal-report"].hide();
      }
    },
    onEdit(toEdit) {
      this.toEdit = toEdit;
    },
    async onEdited() {
      let request = new CommentRequest(
        this.comment.id,
        this.comment.description,
        this.comment.user.id,
        this.postId
      );

      let res = await commentService.edit(request).catch((err) => {
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

        this.reportComment = "";
      });

      if (res.status === 200) {
        this.reportComment = "";
        this.$swal({
          icon: "success",
          position: "bottom-right",
          title: "Comentário editado!",
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      }

      this.toEdit = false;
    },
  },
};
</script>

<style>
#commentOptionsDropdown .dropdown-toggle {
  padding: 0 !important;
}
</style>
