<template>
  <div>
    <h5 class="mb-3 font-weight-bold">Gestão de feedbacks</h5>
    <b-table
      ref="feedbackTable"
      sticky-header="500px"
      striped
      bordered
      borderless
      outlined
      table-variant="light"
      :fields="fields"
      :items="feedbacks"
    >
      <template #cell(user)="data">
        <b-link :to="'/profile/' + data.item.user.id">
          {{ data.item.user.name }} ({{ data.item.user.email }})</b-link
        >
      </template>
      <template #cell(description)="data">
        {{ data.item.description | truncate(30, "...") }}
      </template>
      <template #cell(feedbackType)="data">
        {{ data.item.feedbackType.name }}
      </template>
      <template #cell(actions)="data">
        <b-button-group>
          <b-button @click="onDetails(data.item)" variant="success"
            >Detalhes</b-button
          >
          <b-button @click="onDelete(data.item)" variant="danger">
            Eliminar
          </b-button>
        </b-button-group>
      </template>
    </b-table>

    <b-modal ref="feedback-details-modal" title="Detalhes" hide-footer>
      <feedback-information-component
        :feedback="feedbackSelected"
      ></feedback-information-component>
      <b-button
        class="mt-3"
        variant="outline-primary"
        block
        @click="closeFeedbackModal"
        >Fechar</b-button
      >
    </b-modal>
  </div>
</template>

<script>
import feedbackService from "../../services/feedbackService";

import FeedbackInformationComponent from "../moderation/FeedbackInformationComponent.vue";

export default {
  name: "feedback-management-component",
  components: { FeedbackInformationComponent },
  data() {
    return {
      feedbacks: [],
      fields: [
        { key: "description", label: "Descrição" },
        { key: "user", label: "Utilizador" },
        { key: "feedbackType", label: "Tipo" },
        { key: "createdAt", label: "Data de criação" },
        { key: "actions", label: "Ações" },
      ],
      feedbackSelected: {},
    };
  },
  async created() {
    this.feedbacks = await feedbackService.getFeedbacks();
  },
  methods: {
    onDetails(feedback) {
      this.feedbackSelected = feedback;
      this.$refs["feedback-details-modal"].show();
    },
    async onDelete(feedback) {
      let res = await feedbackService.delete(feedback.id).catch((err) => {
        this.$root.$emit("show-alert", {
          alertMessage: "Ocorreu um erro: " + err.response.message,
          variant: "danger",
        });
      });

      if (res.status === 200) {
        const index = this.feedbacks.findIndex((f) => f.id === feedback.id);

        if (index >= 0) {
          this.feedbacks.splice(index, 1);
        }

        this.$refs.feedbackTable.refresh();

        this.$root.$emit("show-alert", {
          alertMessage: "Feedback eliminado sucesso!",
          variant: "success",
        });
      }
    },
    closeFeedbackModal() {
      this.$refs["feedback-details-modal"].hide();
    },
  },
};
</script>
