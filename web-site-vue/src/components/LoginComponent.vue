<template>
  <div class="mt-4 w-50 text-center m-auto">
    <b-alert v-if="errorMessage" show variant="danger"> {{ errorMessage }} </b-alert>
    <br />
    <h4 class="mb-4">Login</h4>
    <b-form @submit.prevent="onSubmit">
      <b-form-input
        id="input-email"
        v-model="form.email"
        type="email"
        placeholder="Email"
        required
      ></b-form-input>
      <br />
      <b-form-input
        id="input-password"
        v-model="form.password"
        placeholder="Password"
        type="password"
        required
      ></b-form-input>
      <br />

      <b-form-checkbox v-model="form.rememberLogin" class="float-left"
        >Manter a sessão iniciada</b-form-checkbox
      >
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

      <b-button type="submit" class="text-white" variant="primary"
        >Entrar</b-button
      >
    </b-form>
  </div>
</template>

<script>
import UserService from "../services/userService";

export default {
  name: "login-component",
  mounted() {
    console.log("Login component mounted.");
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errorMessage: ''
    };
  },
  methods: {
    async onSubmit() {
      await UserService.login(this.form).then(() => {
        this.redirectToHome();
      }).catch(err => {
        this.errorMessage = err.response.data.message;
      });

      return;

      //if (response.status == 200) this.redirectToHome();

      // this.axios.post("http://127.0.0.1:8000/api/login", this.form)
      //     .then((res) => {
      //         console.log(res);
      //         this.redirectToHome();
      //     })
      //     .catch((err) => {
      //     console.log(err);
      // });

      //alert(JSON.stringify(this.form))
    },
    redirectToHome() {
      window.location.href = "/";
    },
  },
};
</script>
