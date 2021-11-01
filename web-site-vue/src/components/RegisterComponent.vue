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
            placeholder="Inserir nome"
            :state="!v$.form.name.$invalid"
            @blur="v$.form.name.$touch"
          ></b-form-input>
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Email *</label>
          <b-input-group append="@edu.atec.pt">
            <b-form-input
              id="input-email"
              v-model="form.email"
              type="text"
              placeholder="Inserir email"
              :state="!v$.form.email.$invalid"
              @blur="v$.form.email.$touch"
            ></b-form-input>
          </b-input-group>
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
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold"
            >Confirmar Password *</label
          >
          <b-form-input
            id="input-confirm-password"
            type="password"
            v-model="confirmPassword"
            placeholder="Confirmar password"
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
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-6">
          <label class="float-left font-weight-bold"
            >Data de nascimento *</label
          >
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
        </div>
        <div class="col-6">
          <label class="float-left font-weight-bold">Foto de perfil</label>
          <b-form-file
            v-model="photo"
            accept=".jpg, .jpeg, .png"
            placeholder="Escolha uma fotografia..."
            drop-placeholder="Escolha uma fotografia..."
          ></b-form-file>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-6"></div>
        <div class="col-6 text-right">
          <b-button
            type="submit"
            class="text-white w-25"
            variant="primary"
            :disabled="this.v$.$invalid"
            >Criar</b-button
          >
        </div>
      </div>
    </b-form>
  </div>
</template>

<script>
import { mapActions } from "vuex";

import userService from "../services/userService";
import districtService from "../services/districtService";
import schoolClassService from "../services/schoolClassService";

import RegisterRequest from "../models/requests/registerRequest";

import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";

const notContainsEduAtecPt = (value) =>
  !value.toLowerCase().includes("@edu.atec.pt");

// const maxOneMb = (value) => value?.size < 1024 * 1024;

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
        profile_picture: null,
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
        if (this.photo) {
          let image = await this.readAsDataURL(this.photo);
          this.form.profile_picture = image.data;
        }

        const request = new RegisterRequest(
          this.form.name,
          this.form.email,
          this.form.password,
          this.form.district_id,
          this.form.school_class_id,
          this.form.birth_date,
          this.form.profile_picture
        );

        res = await userService.register(request).catch((err) => {
          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors);
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

        if (res.status === 201) {
          window.localStorage.setItem(
            "registerRequest",
            JSON.stringify(request)
          );

          window.location.href = "/verification";
        }
      } else {
        this.showErrorAlert = true;
        this.formStatus =
          "Existem campos inválidos. Por favor, reveja o formulário.";
        this.showAlert();
      }
    },
    readAsDataURL(file) {
      return new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = function() {
          return resolve({
            data: fileReader.result,
            name: file.name,
            size: file.size,
            type: file.type,
          });
        };
        fileReader.readAsDataURL(file);
      });
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
      const res = await districtService.getDistricts();
      const districts = res.map((res) => ({
        value: res.id,
        text: res.name,
      }));

      this.districts.push({
        value: null,
        text: "Escolha um distrito",
        disabled: true,
      });

      this.districts.push(...districts);
    },
    async getSchoolClasses() {
      const res = await schoolClassService.getSchoolClasses();
      const schoolClasses = res.map((x) => ({
        value: x.id,
        text: `${x.name} - ${x.school.name}`,
      }));

      this.schoolClasses.push({
        value: null,
        text: "Escolha uma turma",
        disabled: true,
      });

      this.schoolClasses.push(...schoolClasses);
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
