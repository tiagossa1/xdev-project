<template>
  <div class="mt-4 w-25 text-center m-auto">
    <b-alert v-if="errorMessage" show variant="danger">
      {{ errorMessage }}
    </b-alert>
    <br />
    <h4 class="mb-4">Login</h4>

    <b-form @submit.prevent="onSubmit">
      <b-container>
        <b-row>
          <b-col sm="12" class="mx-auto">
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
              class="text-danger font-weight-bold float-left small mt-1"
              v-if="v$.form.email.required.$invalid"
            >
              O campo email é obrigatório.
              <br />
            </div>
          </b-col>
        </b-row>
        <br>

        <b-row>
          <b-col sm="11" class="mx-auto">
            <b-form-input
              id="input-password"
              v-model="form.password"
              placeholder="Password"
              :type="showPassword ? 'text' : 'password'"
              :state="!v$.form.password.$invalid"
            ></b-form-input>
            <div
              class="text-danger font-weight-bold float-left small mt-1"
              v-if="v$.form.password.required.$invalid"
            >
              O campo password é obrigatório.
              <br />
            </div>
          </b-col>
          <b-col sm="1" class="mx-auto">
            <b-icon
              class="cursor-pointer mt-2"
              @click="showPassword = !showPassword"
              :icon="showPassword ? 'eye-fill' : 'eye-slash-fill'"
            ></b-icon>
          </b-col>
        </b-row>

        <b-row>
          <b-col sm="12" class="mx-auto">
            <div style="margin-top: 2rem">
              <div>Não tem conta?</div>
            </div>
          </b-col>
        </b-row>
        <b-row>
          <b-col sm="12" class="mx-auto">
            <div>
              <router-link to="/register">Criar Conta</router-link>
            </div>
          </b-col>
        </b-row>

        <!-- <b-row>
          <b-col sm="12">
            <div style="margin-top: 1rem">
              <div>Esqueceu-se da palavra-passe?</div>
            </div>
          </b-col>
        </b-row>
        <b-row>
          <b-col sm="12">
            <div>
              <router-link to="/recover">Recuperar password</router-link>
            </div>
          </b-col>
        </b-row> -->

        <b-button
          style="margin-top: 1rem"
          type="submit"
          class="text-white"
          variant="primary"
          :disabled="this.v$.$invalid"
          >Entrar</b-button
        >
      </b-container>
    </b-form>
  </div>
</template>

<script>
import LoginRequest from "../models/requests/loginRequest";

import { mapActions } from "vuex";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

// custom validation
const notContainsEduAtecPt = (value) =>
  !value.toLowerCase().includes("@edu.atec.pt");

export default {
  name: "login-component",
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      form: {
        email: { required, notContainsEduAtecPt },
        password: { required },
      },
    };
  },
  data() {
    return {
      showPassword: false,
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
        const email = this.form.email + "@edu.atec.pt";
        let request = new LoginRequest(email, this.form.password);

        this.signIn(request);
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
