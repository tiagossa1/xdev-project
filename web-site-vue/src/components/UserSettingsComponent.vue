<template>
  <b-modal id="modal2" size="lg" ref="modal2" hide-footer title="Editar perfil">
    <b-tabs content-class="mt-3">
      <b-tab title="Editar Password" active>
        <b-form @submit.prevent="updatePassword">
          <b-row>
            <b-col>
              <b-row>
                <b-col sm="4">
                  <label for="input-password">Password atual</label>
                </b-col>
                <b-col>
                  <b-row>
                    <b-col sm="10">
                      <b-form-input
                        id="input-password"
                        v-model="old_password"
                        :state="!v$.old_password.$invalid"
                        @blur="v$.old_password.$touch"
                        :type="showPassword ? 'text' : 'password'"
                        sm="2"
                      ></b-form-input>

                      <div
                        class="
                          text-danger
                          font-weight-bold
                          float-left
                          small
                          mt-1
                        "
                        v-if="v$.old_password.required.$invalid"
                      >
                        Introduza a password.
                      </div>
                    </b-col>
                    <b-col @click="showPassword = !showPassword">
                      <b-icon
                        class="text-center"
                        :icon="showPassword ? 'eye-fill' : 'eye-slash-fill'"
                      ></b-icon>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
          <b-row class="mt-3">
            <b-col sm="4">
              <label for="input-newPassword">Nova password</label>
            </b-col>
            <b-col>
              <b-row>
                <b-col sm="10">
                  <b-form-input
                    id="input-newPassword"
                    v-model="confirm_password"
                    :type="showNewPassword ? 'text' : 'password'"
                  ></b-form-input>
                </b-col>
                <b-col @click="showNewPassword = !showNewPassword">
                  <b-icon
                    class="text-center"
                    :icon="showNewPassword ? 'eye-fill' : 'eye-slash-fill'"
                  ></b-icon>
                </b-col>
              </b-row>
            </b-col>
          </b-row>

          <b-row class="mt-3">
            <b-col sm="4">
              <label for="input-confirmNewPassword">Confirmar password</label>
            </b-col>
            <b-col>
              <b-row>
                <b-col sm="10">
                  <b-form-input
                    id="input-confirmNewPassword"
                    v-model="confirm_new_password"
                    :type="showNewPassword ? 'text' : 'password'"
                    sm="2"
                  ></b-form-input>
                </b-col>
              </b-row>
            </b-col>
          </b-row>

          <b-row class="mt-3 text-center">
            <b-col>
              <b-button class="text-white" type="submit" variant="success"
                >Atualizar</b-button
              >
            </b-col>
          </b-row>
        </b-form>
      </b-tab>

      <b-tab title="Editar Redes Sociais">
        <b-form @submit.prevent="updateSocial">
          <b-row>
            <b-col>
              <b-row>
                <b-col sm="3">
                  <label for="input-git">Github:</label>
                </b-col>
                <b-col>
                  <b-form-input
                    id="input-git"
                    type="text"
                    v-model="userInfo.github_url"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col sm="3">
                  <label for="input-linkedin">Linkedin:</label>
                </b-col>
                <b-col>
                  <b-form-input
                    type="text"
                    v-model="userInfo.linkedin_url"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col sm="3">
                  <label for="input-facebook">Facebook:</label>
                </b-col>
                <b-col>
                  <b-form-input
                    id="input-facebook"
                    type="text"
                    v-model="userInfo.facebook_url"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col sm="3">
                  <label for="input-instagram">Instagram:</label>
                </b-col>
                <b-col>
                  <b-form-input
                    id="input-instagram"
                    type="text"
                    v-model="userInfo.instagram_url"
                  ></b-form-input>
                </b-col>
              </b-row>
            </b-col>
          </b-row>

          <b-row class="mt-3 text-center">
            <b-col>
              <b-button class="text-white" type="submit" variant="success"
                >Atualizar</b-button
              >
            </b-col>
          </b-row>
        </b-form>
      </b-tab>

      <b-tab title="Editar Tags">
        <b-table
          hover
          sticky-header="500px"
          :tbody-tr-class="rowClass"
          :items="allTags"
          :fields="tagsFields"
        >
          <!-- eslint-disable-next-line -->
          <template #cell(allTags.name)="data">
            <span>{{ data.item.name }}</span>
          </template>

          <template v-slot:cell(actions)="data">
            <b-button-group>
              <b-button
                @click="updateFavouriteTag(data.item)"
                :variant="
                  !userInfo.tags.some((x) => x.id === data.item.id)
                    ? 'success'
                    : 'danger'
                "
              >
                {{
                  !userInfo.tags.some((x) => x.id === data.item.id)
                    ? "Adicionar"
                    : "Remover"
                }}
              </b-button>
            </b-button-group>
          </template>
        </b-table>
      </b-tab>
    </b-tabs>
    <b-row class="text-center mt-3">
      <b-col>
        <b-button variant="outline-danger" @click="closeModel">Sair</b-button>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script>
import { mapActions } from "vuex";

import UserRequest from "../models/requests/userRequest";
import ChangePasswordRequest from "../models/requests/changePasswordRequest";

import userService from "../services/userService";
import tagService from "../services/tagService";

import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";

export default {
  name: "user-settings",
  data() {
    return {
      dismissSecs: 5,
      dismissCountDown: 0,
      tagsFields: [
        { key: "allTags.name", label: "Tags" },
        { key: "actions", label: "Ações" },
      ],
      favouriteTag: false,
      userInfo: {},
      allTags: {},
      showPassword: false,
      showNewPassword: false,
      old_password: "",
      confirm_password: "",
      confirm_new_password: "",
    };
  },
  async mounted() {
    const userId = this.$store.getters["auth/user"]?.id;

    if (userId) {
      this.userInfo = await userService.getUserById(userId);
      this.allTags = await tagService.getTags();
    }
  },

  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      old_password: { required, minLength: minLength(6) },
      confirm_password: { required, minLength: minLength(6) },
      confirm_new_password: { required, sameAs: sameAs(this.confirm_password) },
    };
  },
  inputState(input) {
    return !!input;
  },
  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
    }),
    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("Login").catch(() => {});
      });
    },
    show() {
      this.$refs.modal2.show();
    },
    closeModel() {
      this.clearPasswordChangeForm();
      this.$refs.modal2.hide();
    },
    clearPasswordChangeForm() {
      this.old_password = "";
      this.confirm_password = "";
      this.confirm_new_password = "";
    },
    async updatePassword() {
      let request = new ChangePasswordRequest(
        this.old_password,
        this.confirm_password,
        this.confirm_new_password
      );

      let res = await userService.changePassword(request).catch((err) => {
        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: err.response.data.message,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });

      if (res.status === 200) {
        this.closeModel();
        this.signOut();
      }
    },
    async updateSocial() {
      // var facebookRegex = /(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w]*\/)*([\w]*)/;
      let facebookRegex = /(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w]*\/)?(?:profile.php\?id=(?=\d.*))?([\w]*)?/;
      var githubRegex = /(?:https\/\/)?(?:www\.)?github\.com\//ig;
      var instagramRegex = /(?:https\/\/)?(?:www\.)(?:instagram.com\/)/ig;
      var linkedinRegex = /(?:https\/\/)?(?:www\.)(?:linkedin.com\/)/ig;
      
      if (
        facebookRegex.test(this.userInfo.facebook_url) &&
        githubRegex.test(this.userInfo.github_url) &&
        instagramRegex.test(this.userInfo.instagram_url) &&
        linkedinRegex.test(this.userInfo.linkedin_url)
      ) {

        if(this.userInfo.facebook_url.startsWith('https://')){
          this.userInfo.facebook_url = this.userInfo.facebook_url.slice(8)
        }
        if(this.userInfo.github_url.startsWith('https://')){
          this.userInfo.github_url = this.userInfo.github_url.slice(8)
        }
        if(this.userInfo.instagram_url.startsWith('https://')){
          this.userInfo.instagram_url = this.userInfo.instagram_url.slice(8)
        }
        if(this.userInfo.linkedin_url.startsWith('https://')){
          this.userInfo.linkedin_url = this.userInfo.linkedin_url.slice(8)
        }
        
        

        let request = new UserRequest(
          this.userInfo.id,
          this.userInfo.email,
          this.userInfo.name,
          this.userInfo.birth_date,
          null,
          this.userInfo.github_url,
          this.userInfo.linkedin_url,
          this.userInfo.facebook_url,
          this.userInfo.instagram_url,
          this.userInfo.createdAt,
          this.userInfo.district.id,
          this.userInfo.schoolClass.id,
          this.userInfo.userType.id,
          null,
          null,
          null,
          null,
          this.userInfo.suspended
        );

        const res = await userService.update(request).catch((err) => {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

        if (res.status === 200) {
          this.$emit("on-social-media-update", this.userInfo);

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Redes sociais editadas.",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        } else {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: res.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        }
      }
    },
    rowClass(item, type) {
      if (!item || type !== "row") {
        return;
      }
      if (this.userInfo.tags.some((x) => x.name == item.name))
        return "table-success";
    },
    async updateFavouriteTag(value) {
      if (!this.userInfo.tags.some((x) => x.id === value.id)) {
        this.userInfo.tags.push(value);
      } else {
        let index = this.userInfo.tags.findIndex((x) => x.id == value.id);

        if (index > -1) {
          this.userInfo.tags.splice(index, 1);
        }
      }

      let request = new UserRequest(
        this.userInfo.id,
        this.userInfo.email,
        this.userInfo.name,
        this.userInfo.birth_date,
        null,
        this.userInfo.github_url,
        this.userInfo.linkedin_url,
        this.userInfo.facebook_url,
        this.userInfo.instagram_url,
        this.userInfo.createdAt,
        this.userInfo.district.id,
        this.userInfo.schoolClass.id,
        this.userInfo.userType.id,
        null,
        this.userInfo.tags.map((x) => x.id),
        null,
        null,
        this.userInfo.suspended
      );

      await userService.update(request).catch((err) => {
        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: err.response.data.message,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });
    },
  },
};
</script>

<style></style>
