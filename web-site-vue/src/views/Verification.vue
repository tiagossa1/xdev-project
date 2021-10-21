<template>
  <div class="container">
    <b-alert :variant="variant" v-if="showAlert" show dismissible>
      {{ alertText }}
    </b-alert>

    <b-jumbotron header="Verificação">
      <p class="mb-2 mt-2">
        Foi enviado um email de verificação para o seu email. Por favor,
        confirme para continuar.
      </p>
      <b-link class="text-primary" @click="onClickResendEmail" href="#"
        >Reenviar email</b-link
      >
    </b-jumbotron>
  </div>
</template>

<script>
import { mapActions } from "vuex";

import userService from "../services/userService";

export default {
  name: "Verification",
  data() {
    return {
      showAlert: false,
      alertText: "",
      variant: "success",
    };
  },
  computed: {
    getLoginRequest() {
      let loginRequest = localStorage.getItem("loginRequest");
      if (loginRequest) {
        return JSON.parse(loginRequest);
      }

      return null;
    },
    getRegisterRequest() {
      let registerRequest = localStorage.getItem("registerRequest");
      if (registerRequest) {
        return JSON.parse(registerRequest);
      }

      return null;
    },
    getEmail() {
      let loginRequest = this.getLoginRequest;
      let registerRequest = this.getRegisterRequest;
      return loginRequest?.email ?? registerRequest?.email;
    },
  },
  async mounted() {
    let intervalId = window.setInterval(async () => {
      let loginRequest = this.getLoginRequest;
      let registerRequest = this.getRegisterRequest;

      let res = await userService.isUserVerified(this.getEmail);
      let isVerified = Boolean(res.data.isVerified);

      if (isVerified) {
        window.clearInterval(intervalId);

        if (loginRequest) {
          window.localStorage.removeItem("loginRequest");
          this.signIn(loginRequest);
        } else {
          window.localStorage.removeItem("registerRequest");
          this.signIn({
            email: registerRequest.email,
            password: registerRequest.password,
          });
        }
      }
    }, 10000);
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    async onClickResendEmail() {
      let res = await userService.resend(this.getEmail).catch((err) => {
        this.alertText = err.response.data;
        this.variant = "danger";
        this.showAlert = true;
      });

      if (res.status === 200) {
        this.alertText = res.data.message;
        this.variant = "success";
        this.showAlert = true;
      }
    },
  },
};
</script>
