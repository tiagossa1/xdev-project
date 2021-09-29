<template>
  <div class="mt-4 w-25 text-center m-auto">
    <b-alert v-if="errorMessage" show variant="danger">
      {{ errorMessage }}
    </b-alert>
    <br />
    <h4 class="mb-4">Login</h4>
    <b-form @submit.prevent="onSubmit">
      <b-input-group append="@edu.atec.pt">
        <b-form-input
          id="input-email"
          v-model.trim="form.email"
          type="text"
          placeholder="Email"
          :state="!v$.form.email.$invalid"
        ></b-form-input>
      </b-input-group>
      <div
        class="text-danger font-weight-bold float-left small mt-1 mb-4"
        v-if="v$.form.email.required.$invalid"
      >
        O campo email é obrigatório.
        <br />
      </div>
      <br />
      <b-form-input
        id="input-password"
        class="mt-2"
        v-model="form.password"
        placeholder="Password"
        type="password"
        :state="!v$.form.password.$invalid"
      ></b-form-input>
      <div
        class="text-danger font-weight-bold float-left small mt-1"
        v-if="v$.form.password.required.$invalid"
      >
        O campo password é obrigatório.
        <br />
        <br />
      </div>
      <div
        class="text-danger font-weight-bold float-left small mt-1"
        v-if="v$.form.password.minLength.$invalid"
      >
        A password tem de ter 6 caracteres.
        <br />
      </div>
      <br />

      <div class="row" style="margin-top: 3rem">
        <div class="col-6">Não tem conta?</div>
        <div class="col-6">
          <router-link to="/register">Criar Conta</router-link>
        </div>
      </div>

      <div class="row mt-2">
        <div class="col-6">Esqueceu-se da palavra-passe?</div>
        <div class="col-6">
          <router-link to="/recover">Recuperar password</router-link>
        </div>
      </div>
      <br />

      <b-button
        type="submit"
        class="text-white"
        variant="primary"
        :disabled="this.v$.$invalid"
        >Entrar</b-button
      >
    </b-form>
  </div>
</template>

<script>
import { mapActions } from "vuex";

import useVuelidate from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";

export default {
  name: "login-component",
  mounted() {
    console.log("Login component mounted.");
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      form: {
        email: { required },
        password: { required, minLength: minLength(6) },
      },
    };
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errorMessage: "",
    };
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),

    onSubmit() {
      if (!this.v$.$invalid) {
        this.signIn(this.form);
      } else {
        this.showErrorAlert = true;
        this.showAlert();
        this.errorMessage =
          "Existem campos inválidos. Por favor, reveja o formulário.";
      }
    },
  },
};
</script>
