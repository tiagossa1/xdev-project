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
          <post-options-component
            @on-deleted="onDeleted"
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
import reportService from "../services/reportService";

import Comment from "../models/comment";
import ReportRequest from "../models/requests/reportRequest";

import PostOptionsComponent from "../components/PostOptionsComponent";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "post-comment-component",
  components: { PostOptionsComponent },
  props: {
    comment: Comment,
  },
  data() {
    return {
      isUserComment: false,
      reportComment: "",
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

        let res = await reportService.createReport(request);

        if (res.status === 200) {
          this.$emit("on-reported", {
            alertMessage: "Comentário reportado com sucesso!",
            variant: "success",
          });
        }

        this.$refs["modal-report"].hide();
      }
    },
  },
};
</script>

<style>
#commentOptionsDropdown .dropdown-toggle {
  padding: 0 !important;
}
</style>