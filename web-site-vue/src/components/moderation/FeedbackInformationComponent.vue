<template>
  <div>
    <b-form-group id="user-group" label="Utilizador">
      <b-form-input
        id="user-input"
        :value="feedback.user.name"
        disabled
      ></b-form-input>
    </b-form-group>

    <b-form-group id="description-group" label="Descrição">
      <b-form-textarea
        id="description"
        :value="feedback.description"
        rows="5"
        max-rows="6"
        disabled
      ></b-form-textarea>
    </b-form-group>

    <b-form-group id="feedback-type-group" label="Tipo">
      <b-form-input
        id="feedback-type-input"
        :value="feedback.feedbackType.name"
        disabled
      ></b-form-input>
    </b-form-group>

    <b-form-group id="created-at-group" label="Data de criação">
      <b-form-input
        id="created-at-input"
        :value="feedback.createdAt"
        disabled
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "feedback-information-component",
  props: { feedback: { user: {}, feedbackType: {} } },
  data() {
    return {};
  },
  methods: {},
};
</script>
