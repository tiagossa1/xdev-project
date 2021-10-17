<template>
  <div>
    <b-form-group id="name-input-group" label="Nome">
      <b-form-input
        id="name-input"
        v-model="user.name"
        :value="user.name"
        type="text"
        :disabled="viewOnly"
        :state="!viewOnly ? !v$.user.name.$invalid : null"
        @blur="v$.user.name.$touch"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="email-input-group" label="Email">
      <b-form-input
        id="email-input"
        v-model="user.email"
        :value="user.email"
        :disabled="viewOnly"
        type="email"
        :state="!viewOnly ? !v$.user.email.$invalid : null"
        @blur="v$.user.email.$touch"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="birth-date-input-group" label="Data de Nascimento">
      <b-form-datepicker
        id="birth-datepicker"
        v-model="user.birth_date"
        :disabled="viewOnly"
        :state="!viewOnly ? !v$.user.birth_date.$invalid : null"
        @blur="v$.user.birth_date.$touch"
        class="mb-2"
      ></b-form-datepicker>
    </b-form-group>

    <b-form-group id="github-url-input-group" label="Github URL">
      <b-form-input
        id="github-url-input"
        v-model="user.github_url"
        :value="user.github_url"
        :disabled="viewOnly"
        :state="!viewOnly ? !v$.user.github_url.$invalid : null"
        @blur="v$.user.github_url.$touch"
        type="email"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="linkedin-url-input-group" label="Linkedin URL">
      <b-form-input
        id="linkedin-url-input"
        v-model="user.linkedin_url"
        :value="user.linkedin_url"
        :state="!viewOnly ? !v$.user.linkedin_url.$invalid : null"
        @blur="v$.user.linkedin_url.$touch"
        :disabled="viewOnly"
        type="text"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="facebook-url-input-group" label="Facebook URL">
      <b-form-input
        id="facebook-url-input"
        v-model="user.facebook_url"
        :value="user.facebook_url"
        :disabled="viewOnly"
        :state="!viewOnly ? !v$.user.facebook_url.$invalid : null"
        @blur="v$.user.facebook_url.$touch"
        type="text"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="instagram-url-input-group" label="Instagram URL">
      <b-form-input
        id="instagram-url-input"
        v-model="user.instagram_url"
        :value="user.instagram_url"
        :disabled="viewOnly"
        :state="!viewOnly ? !v$.user.instagram_url.$invalid : null"
        @blur="v$.user.instagram_url.$touch"
        type="text"
        required
      >
      </b-form-input>
    </b-form-group>

    <b-form-group id="districts-input-group" label="Distrito">
      <b-form-select
        v-model="user.district.id"
        :options="districts"
        :disabled="viewOnly"
      ></b-form-select>
    </b-form-group>

    <b-form-group id="user-type-input-group" label="Tipo">
      <b-form-select
        v-model="user.userType.id"
        :options="userTypes"
        :disabled="viewOnly"
      ></b-form-select>
    </b-form-group>

    <b-form-group id="school-class-input-group" label="Turma">
      <b-form-select
        v-model="user.schoolClass.id"
        :options="schoolClasses"
        :disabled="viewOnly"
      ></b-form-select>
    </b-form-group>
  </div>
</template>

<script>
import User from "../../models/user";

import districtService from "../../services/districtService";
import userService from "../../services/userService";
import schoolClassService from "../../services/schoolClassService";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "user-information-component",
  props: {
    user: User,
    viewOnly: {
      default: true,
      type: Boolean,
    },
  },
  data() {
    return {
      districts: [],
      userTypes: [],
      schoolClasses: [],
    };
  },
  async mounted() {
    let districts = await districtService.getDistricts();
    this.districts = districts.map((d) => ({ value: d.id, text: d.name }));

    let userTypes = await userService.getUserTypes();
    this.userTypes = userTypes.map((ut) => ({ value: ut.id, text: ut.name }));

    let schoolClasses = await schoolClassService.getSchoolClasses();
    this.schoolClasses = schoolClasses.map((sc) => ({
      value: sc.id,
      text: sc.name,
    }));
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      user: {
        email: { required },
        name: { required },
        birth_date: { required },
        github_url: { required },
        linkedin_url: { required },
        facebook_url: { required },
        instagram_url: { required },
        // profile_picture: { required },
        district: {
          id: { required },
        },
        userType: {
          id: { required },
        },
        schoolClass: {
          id: { required },
        },
      },
    };
  },
  watch: {
    "v$.$invalid"() {
      this.$emit("form-status", !this.v$.$invalid);
    },
  },
};
</script>