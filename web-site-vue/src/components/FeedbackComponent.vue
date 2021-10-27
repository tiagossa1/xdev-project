<template>
  <b-modal @ok="onSubmit" id="feedback" ref="feedback" title="Feedback">
    <b-form-group
      id="input-group-1"
      label="Tipo de Feedback"
      label-for="input-1"
    >
      <b-form-select
        v-model="selected"
        :options="feedbackTypesSelect"
        :state="!v$.selected.$invalid"
      ></b-form-select>
    </b-form-group>
    <b-form-group id="input-group-1" label="Descrição" label-for="input-1">
      <b-form-textarea
        id="textarea"
        v-model="description"
        rows="4"
        max-rows="6"
        :state="!v$.description.$invalid"
      ></b-form-textarea>
    </b-form-group>
  </b-modal>
</template>

<script>
import { mapGetters } from "vuex";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

import FeedbackRequest from "../models/requests/feedbackRequest";

import feedbackService from "../services/feedbackService";
import feedbackTypeService from "../services/feedbackTypeService";

export default {
  name: "feedback-component",
  data() {
    return {
      feedbackTypes: [],
      feedbackTypesSelect: [],
      selected: null,
      description: "",
      modalShow: false,
    };
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      selected: { required },
      description: { required },
    };
  },
  async created() {
    if (this.authenticated) {
      let feedbackTypes = await feedbackTypeService.getFeedbackTypes();
      this.feedbackTypes = feedbackTypes;
      this.feedbackTypesSelect = feedbackTypes.map((x) => ({
        value: x.id,
        text: x.name,
      }));

      this.feedbackTypesSelect.unshift({
        value: null,
        text: "Selecione uma opção...",
        disabled: true,
      });
    }
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
    }),
  },
  methods: {
    show() {
      this.$refs.feedback.show();
    },
    async onSubmit(bvModalEvt) {
      if (!this.v$.$invalid) {
        const request = new FeedbackRequest(
          this.description,
          this.$store.getters["auth/user"].id,
          this.selected
        );
        const res = await feedbackService.create(request);

        if (res.status === 201) {
          this.description = "";
          this.selected = "";
          
          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Feedback criado.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3500,
          });
        }

        this.$nextTick(() => {
          this.$bvModal.hide("modal-prevent-closing");
        });
      } else {
        bvModalEvt.preventDefault();
      }
    },
  },
};
</script>