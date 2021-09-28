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
          <br />
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
          <div
            class="text-danger font-weight-bold float-left small mt-1"
            v-if="v$.form.school_class_id.required.$invalid"
          >
            O campo turma é obrigatório.
            <br />
          </div>
        </div>
      </div>
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
        <div class="col-6"></div>
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
import userService from "../services/userService";
import districtService from "../services/districtService";
import schoolClassService from "../services/schoolClassService";

import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";

export default {
  name: "register-component",
  data() {
    //min: 1900
    //max: data atual
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    return {
      districts: [],
      schoolClasses: [],
      max: today,
      min: new Date(1900, 1, 1),
      dismissSecs: 5,
      dismissCountDown: 0,
      showErrorAlert: false,
      confirmPassword: "",
      formStatus: "",
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
        email: { required },
        password: { required, minLength: minLength(6) },
        school_class_id: { required },
        birth_date: { required },
      },
      confirmPassword: { required, sameAs: sameAs(this.form.password) },
    };
  },
  mounted() {
    console.log("Register component mounted.");
  },
  methods: {
    onSubmit() {
      if (!this.v$.$invalid) {
        this.form.email += "@edu.atec.pt";
        userService.register(this.form);
      } else {
        this.showErrorAlert = true;
        this.showAlert();
        this.formStatus =
          "Existem campos inválidos. Por favor, reveja o formulário.";
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
      const config = {
        headers: {
          Authorization: `Bearer 1|7X7BTKjq40o7vfRHPqaeDYalI2Qm3FHDLOm0Cd4n`,
        },
      };

      districtService.getDistricts(config).then((res) => {
        this.districts = res.data.data.map((x) => ({
          value: x.id,
          text: x.name,
        }));
      });
    },
    async getSchoolClasses() {
      const config = {
        headers: {
          Authorization: `Bearer 1|7X7BTKjq40o7vfRHPqaeDYalI2Qm3FHDLOm0Cd4n`,
        },
      };

      schoolClassService.getSchoolClasses(config).then((res) => {
        this.schoolClasses = res.data.data.map((x) => ({
          value: x.id,
          text: x.name,
        }));
      });
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
