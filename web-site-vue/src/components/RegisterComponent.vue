<template>
  <div class="mt-4 w-75 m-auto">
    <b-alert
      :show="dismissCountDown"
      dismissible
      variant="danger"
      @dismissed="dismissCountDown = 0"
      @dismiss-count-down="countDownChanged"
    >
      {{ formStatus }}
      <b-progress
        variant="danger"
        :max="dismissSecs"
        :value="dismissCountDown"
        height="4px"
        class="mt-3"
      ></b-progress>
    </b-alert>
    <h2 class="mt-4 mb-4 text-center">Criar Conta</h2>
    <b-form @submit.prevent="onSubmit">
      <div class="row">
        <div class="col-6">
          <label class="float-left font-weight-bold">Nome *</label>
          <b-form-input
            id="input-name"
            v-model.trim="form.name"
            name="name"
            type="text"
            placeholder="Inserir o nome"
            :state="!v$.form.name.$invalid"
            @blur="v$.form.name.$touch"
          ></b-form-input>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.name.required.$invalid"
          >
            O campo nome é obrigatório.
          </div>
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Email *</label>
          <b-input-group append="@edu.atec.pt">
            <b-form-input
              id="input-email"
              v-model="form.email"
              type="text"
              placeholder="Inserir o email"
              :state="!v$.form.email.$invalid"
              @blur="v$.form.email.$touch"
            ></b-form-input>
          </b-input-group>

          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.email.required.$invalid"
          >
            O campo email é obrigatório
          </div>
        </div>
      </div>
      <br />

      <div class="row">
        <div class="col-6">
          <label class="float-left font-weight-bold">Password *</label>
          <b-form-input
            id="input-password"
            v-model="form.password"
            name="password"
            placeholder="Inserir password"
            type="password"
            :state="!v$.form.password.$invalid"
            @blur="v$.form.password.$touch"
          ></b-form-input>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.password.required.$invalid"
          >
            O campo password é obrigatório.
          </div>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.password.minLength.$invalid"
          >
            O campo password deve ter pelo menos 6 caracteres.
          </div>
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Confirmar Password</label>
          <b-form-input
            id="input-confirm-password"
            type="password"
            v-model="confirmPassword"
            placeholder="Inserir o password"
            :state="!v$.confirmPassword.$invalid"
            @blur="v$.confirmPassword.$touch"
          ></b-form-input>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.confirmPassword.required.$invalid"
          >
            Confirme a password.
          </div>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.confirmPassword.sameAs.$invalid"
          >
            As passwords não são iguais.
          </div>
        </div>
      </div>
      <br />

      <div class="row">
        <div class="col-6">
          <label class="float-left font-weight-bold">Distrito *</label>
          <b-form-select
            id="input-2"
            v-model="form.district_id"
            name="district_id"
            :options="districts"
            :state="!v$.form.district_id.$invalid"
            @blur="v$.form.district_id.$touch"
          ></b-form-select>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.district_id.required.$invalid"
          >
            O campo do distrito é obrigatório.
          </div>
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Turma *</label>
          <b-form-select
            id="input-3"
            name="school_class_id"
            v-model="form.school_class_id"
            :options="schoolClasses"
            :value="null"
            :state="!v$.form.school_class_id.$invalid"
            @blur="v$.form.school_class_id.$touch"
          ></b-form-select>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.school_class_id.required.$invalid"
          >
            O campo turma é obrigatório.
            <br />
          </div>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-6">
          <label class="float-left font-weight-bold">Data de nascimento</label>
          <b-form-datepicker
            v-model="form.birth_date"
            :date-format-options="{
              year: 'numeric',
              month: 'numeric',
              day: 'numeric',
            }"
            :min="min"
            :max="max"
            name="birth_date"
            :state="!v$.form.birth_date.$invalid"
            @blur="v$.form.birth_date.$touch"
            class="mb-2"
          >
          </b-form-datepicker>
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.birth_date.required.$invalid"
          >
            O campo data de nascimento é obrigatório.
          </div>
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Foto de perfil</label>
          <b-form-file
            v-model="photo"
            accept=".jpg, .png"
            placeholder="Escolha uma fotografia..."
            drop-placeholder="Escolha uma fotografia..."
          ></b-form-file>
        </div>
      </div>
      <br />

      <div class="text-center">
        <b-button
          type="submit"
          class="text-white"
          variant="primary"
          :disabled="this.v$.$invalid"
          >Criar</b-button
        >
      </div>
    </b-form>
  </div>
</template>

<script>
import { mapActions } from "vuex";

import userService from "../services/userService";
// import imageUploadService from "../services/imageUploadService";
import districtService from "../services/districtService";
import schoolClassService from "../services/schoolClassService";

// import ImageUploadRequest from "../models/requests/imageUploadRequest";

import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";

const notContainsEduAtecPt = (value) => !value.toLowerCase().includes("@edu.atec.pt");

export default {
  name: "register-component",
  data() {
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    return {
      districts: [],
      schoolClasses: [],
      max: today,
      min: new Date(1900, 1, 1),
      dismissSecs: 10,
      dismissCountDown: 0,
      showErrorAlert: false,
      confirmPassword: "",
      formStatus: "",
      photo: null,
      form: {
        name: "",
        email: "",
        password: "",
        district_id: null,
        school_class_id: null,
        birth_date: "",
        user_type_id: 1,
      },
    };
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      form: {
        name: { required },
        email: { required, notContainsEduAtecPt },
        password: { required, minLength: minLength(6) },
        district_id: { required },
        school_class_id: { required },
        birth_date: { required },
      },
      confirmPassword: { required, sameAs: sameAs(this.form.password) },
    };
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),

    async onSubmit() {
      let res = null;
      if (!this.v$.$invalid) {
        if (!this.form.email.includes("@edu.atec.pt")) {
          // this.form.email += "@edu.atec.pt";
        

          res = await userService.register(this.form).catch((err) => {
            this.showErrorAlert = true;
            this.formStatus = Object.values(err.response.data.errors)
              .map((x) => x[0])
              .toString();
            this.showAlert();
          });

          if (res.status === 201) {
            window.localStorage.setItem(
              "registerRequest",
              JSON.stringify(this.form)
            );
            window.location.href = "/verification";
          }
        }
        // if (res.status === 201) {
        //   this.signIn({
        //     email: this.form.email,
        //     password: this.form.password,
        //   });

        //   const config = {
        //     headers: { Authorization: `Bearer ${res.data.token}` },
        //   };

        //   let request = new ImageUploadRequest(res.data.user.id, this.photo);

        //   res = await imageUploadService
        //     .createImageUpload(config, request)
        //     .catch((err) => {
        //       console.log(err.response);
        //     });
        // }
      } else {
        this.showErrorAlert = true;
        this.formStatus =
          "Existem campos inválidos. Por favor, reveja o formulário.";
        this.showAlert();
      }
    },
    redirectToCreateAccount() {
      window.location.href = "/register";
    },
    redirectToRecoverPassword() {
      window.location.href = "/recover";
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    async getDistrict() {
      let res = await districtService.getDistricts();

      this.districts = res.map((res) => ({
        value: res.id,
        text: res.name,
      }));
    },
    async getSchoolClasses() {
      let res = await schoolClassService.getSchoolClasses();

      this.schoolClasses = res.map((x) => ({
        value: x.id,
        text: x.name,
      }));
    },
    inputState(input) {
      return !!input;
    },
    passwordState() {
      return (
        !!this.form.password &&
        !!this.confirmPassword &&
        this.form.password === this.confirmPassword
      );
    },
  },
  created() {
    this.getDistrict();
    this.getSchoolClasses();
  },
};
</script>
