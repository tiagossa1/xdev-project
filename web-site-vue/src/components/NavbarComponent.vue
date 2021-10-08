<template>
  <b-navbar
    toggleable="lg"
    type="dark"
    style="background-color: rgb(0, 174, 239)"
  >
    <b-navbar-brand class="font-weight-bold" to="/home">xDev</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav class="ml-auto">
        <template v-if="authenticated">
          <b-nav-form>
            <b-input-group size="md">
              <b-input-group-prepend is-text>
                <b-icon icon="search"></b-icon>
              </b-input-group-prepend>
              <b-form-tags
                input-id="tags-separators"
                v-model="value"
                placeholder="Pesquise por tags..."
                remove-on-delete
                style="width: 35rem"
              ></b-form-tags>
            </b-input-group>
            <b-button size="md" class="ml-2" variant="light" type="submit"
              >Procurar</b-button
            >
          </b-nav-form>
        </template>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <template v-if="authenticated">
          <b-nav-item-dropdown right>
            <template #button-content>
              <span class="mr-2"> {{ user.name }} </span>
              <b-avatar src="https://placekitten.com/300/300"></b-avatar>
            </template>
            <b-dropdown-item to="/profile">O meu perfil</b-dropdown-item>
            <b-dropdown-item v-b-modal.modal-1>Configurações</b-dropdown-item>
            <b-dropdown-item @click.prevent="signOut">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </template>

        <template v-else>
          <div
            v-if="this.$router.currentRoute.name !== 'Login'"
            class="align-self-center"
          >
            <router-link to="/login" class="text-white mr-2"
              >Entrar</router-link
            >
          </div>
        </template>
      </b-navbar-nav>


      <b-modal id="modal-1" ref="modal-1" hide-footer title="Editar perfil">

        <b-tabs content-class="mt-3">
          <b-tab title="Editar Password" active>
            <b-form @submit.prevent="onSubmit">
          <b-row>
            <b-col sm="4">
              <label for="input-password">Password atual</label>
            </b-col>
            <b-col>
              <b-row>
                <b-col sm="10">
                  <b-form-input 
                    id="input-password" 
                    v-model="actualPassword"
                    :state="!v$.actualPassword.$invalid"
                    @blur="v$.actualPassword.$touch"
                    :type="showPassword ? 'text' : 'password'"
                    sm="2" 
                  ></b-form-input>

                  <div
                    class="text-danger font-weight-bold float-left small mt-1"
                    v-if="v$.actualPassword.required.$invalid"
                  >
                    Introduza a password.
                  </div>
                  
                </b-col>
                <b-col @click="showPassword = !showPassword">
                  <b-icon class="text-center" :icon="showPassword ? 'eye-fill' : 'eye-slash-fill'"></b-icon>
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
                  <b-form-input id="input-newPassword" :type="showNewPassword ? 'text' : 'password'" sm="2" ></b-form-input>
                </b-col>
                <b-col @click="showNewPassword = !showNewPassword">
                  <b-icon class="text-center" :icon="showNewPassword ? 'eye-fill' : 'eye-slash-fill'"></b-icon>
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
                    v-model="confirmNewPassword" 
                    :type="showNewPassword ? 'text' : 'password'" sm="2"
                  ></b-form-input>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        
          <b-row class="mt-3 text-center">
            <b-col>
              <b-button 
                class="text-white" 
                type="submit" 
                variant="primary"
                :disabled="this.v$.$invalid"
              >Atualizar</b-button>
            </b-col>
          </b-row>
        </b-form>
        </b-tab>

        <b-tab title="Editar Redes Sociais">
          <b-row>
          <b-col sm="3">
            <label for="input-git">Github :</label>
          </b-col>
          <b-col>
            <b-row>
              <b-col>
                <b-form-input id="input-git" type="text" :value="userInfo.github_url"></b-form-input>
              </b-col>
            </b-row>
          </b-col>
        </b-row>

        <b-row class="mt-3">
          <b-col sm="3">
            <label for="input-linkedin">Linkedin :</label>
          </b-col>
          <b-col>
            <b-row>
              <b-col>
                <b-form-input id="input-linkedin" type="text" :value="userInfo.linkedin_url"></b-form-input>
              </b-col>
            </b-row>
          </b-col>
        </b-row>

        <b-row class="mt-3">
          <b-col sm="3">
            <label for="input-facebook">Facebook :</label>
          </b-col>
          <b-col>
            <b-row>
              <b-col>
                <b-form-input id="input-facebook" type="text" :value="userInfo.facebook_url"></b-form-input>
              </b-col>
            </b-row>
          </b-col>
        </b-row>

        <b-row class="mt-3">
          <b-col sm="3">
            <label for="input-instagram">Instagram :</label>
          </b-col>
          <b-col>
            <b-row>
              <b-col>
                <b-form-input id="input-instagram" type="text" :value="userInfo.instagram_url"></b-form-input>
              </b-col>
            </b-row>
          </b-col>
        </b-row>

        <b-row class="mt-3 text-center">
          <b-col>
            <b-button variant="success">Atualizar</b-button>
          </b-col>
        </b-row>

        
        </b-tab>

        </b-tabs>
        <b-button class="mt-3" variant="outline-danger" block @click="closeModel">Sair</b-button>
      </b-modal>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import userService from "../services/userService";

import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";



export default {
  name: "navbar-component",
  async mounted() {
    console.log("Navbar component mounted.");
    this.userInfo = await userService
      .getUserById(this.$store.getters["auth/user"].id);
  },
  data() {
    return {
      showPassword: false,
      showNewPassword: false,
      value: [],
      userInfo: {},

      actualPassword: "",
      confirmPassword: "",
      confirmNewPassword: "",
    };
  },
  
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      actualPassword: { required, minLength: minLength(6) },
      confirmPassword: { required, minLength: minLength(6) },
      confirmNewPassword: { required, sameAs: sameAs(this.confirmPassword) }
    };
  },
  inputState(input) {
    return !!input;
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
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

    closeModel(){
      console.log('f')
      this.$refs['modal-1'].hide()
    },

    async onSubmit(){
      //let res = null ;
      if(!this.v$.$invalid){
        console.log('d')
      }
    }
  },
  
};
</script>
