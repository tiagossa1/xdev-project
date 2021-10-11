<template>
  <b-modal id="modal2" ref="modal2" hide-footer title="Editar perfil" @close="DetectCloseModal" @hide="DetectCloseModal">
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
                  <b-row >
                    <b-col sm="10">
                      <b-form-input
                        id="input-newPassword"
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
                  <label for="input-confirmNewPassword"
                    >Confirmar password</label
                  >
                </b-col>
                <b-col>
                  <b-row>
                    <b-col sm="10">
                      <b-form-input
                        id="input-confirmNewPassword"
                        v-model="confirmNewPassword"
                        :type="showNewPassword ? 'text' : 'password'"
                        sm="2"
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
                <label for="input-git">Github :</label>
              </b-col>
              <b-col>
                <b-form-input id="input-git" type="text" v-model="socialLinks.github_url"></b-form-input>
              </b-col>
            </b-row>

            <b-row class="mt-3">
              <b-col sm="3">
                <label for="input-linkedin">Linkedin :</label>
              </b-col>
              <b-col>
                <b-form-input id="input-linkedin" type="text" v-model="socialLinks.linkedin_url"></b-form-input>
              </b-col>
            </b-row>

            <b-row class="mt-3">
              <b-col sm="3">
                <label for="input-facebook">Facebook :</label>
              </b-col>
              <b-col>
                <b-form-input id="input-facebook" type="text" v-model="socialLinks.facebook_url"></b-form-input>
              </b-col>
            </b-row>

            <b-row class="mt-3">
              <b-col sm="3">
                <label for="input-instagram">Instagram :</label>
              </b-col>
              <b-col>
                <b-form-input id="input-instagram" type="text" v-model="socialLinks.instagram_url"></b-form-input>
              </b-col>
            </b-row>
          </b-col>
        </b-row>

        <b-row class="mt-3 text-center">
          <b-col>
            <b-button type="submit" variant="success">Atualizar</b-button>
          </b-col>
        </b-row>

        </b-form>
        </b-tab>
        </b-tabs>
        <b-button
          class="mt-3"
          variant="outline-danger"
          block
          @click="closeModel"
          >Sair</b-button
        >
      </b-modal>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, minLength, sameAs } from "@vuelidate/validators";
//import user from '../models/user.js'
import userService from "../services/userService";
export default {
    name: 'user-settings',
    data(){
        return{
            userInfo: {},
            showPassword: false,
            showNewPassword: false,
            actualPassword: "",
            confirmPassword: "",
            confirmNewPassword: "",

            socialLinks: {
                linkedin_url : "",
                github_url : "",
                facebook_url : "",
                instagram_url : "",
            }
        }
    },
    async mounted() {
        this.userInfo = await userService
        .getUserById(this.$store.getters["auth/user"].id);

        console.log(this.userInfo)
        this.socialLinks.github_url = this.userInfo.github_url
        this.socialLinks.facebook_url = this.userInfo.facebook_url
        this.socialLinks.instagram_url = this.userInfo.instagram_url
        this.socialLinks.linkedin_url = this.userInfo.linkedin_url
    },
    setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      actualPassword: { required, minLength: minLength(6) },
      confirmPassword: { required, minLength: minLength(6) },
      confirmNewPassword: { required, sameAs: sameAs(this.confirmPassword) },
    };
  },
  inputState(input) {
    return !!input;
  },
  methods:{
    show(){
        this.$refs.modal2.show();
    },
    closeModel(){
      this.$refs.modal2.hide()
    },

    async updatePassword(){
      //let res = null ;
      if (!this.v$.$invalid) {
        console.log("d");
      }
    },
    async updateSocial(){
      //VERIFICAR SE TEM ALGUM LINK DIFERENTE DOS ATUAIS (TEM DE TER PELO MENOS 1 PARA PODER ATUALIZAR)
      /*if(this.socialLinks.github_url === this.userInfo.github_url 
      && this.socialLinks.facebook_url === this.userInfo.facebook_url
      && this.socialLinks.instagram_url === this.userInfo.instagram_url
      && this.socialLinks.linkedin_url === this.userInfo.linkedin_url){
        console.log('todos iguais')
      }
      else{
        //Verificar se o url está correto || acrescentar mais validações
      if(this.socialLinks.facebook_url.indexOf('www.facebook.com/') !== -1 && 
        this.socialLinks.github_url.indexOf('www.github.com/') !== -1 && 
        this.socialLinks.instagram_url.indexOf('www.instagram.com/') !== -1 &&
        this.socialLinks.linkedin_url.indexOf('www.linkedin.com/') !== -1
      )
      {
       console.log('links "válidos" ')
      }
      else{
        console.log('links inválidos')
      }
        console.log('dif')
      }*/
      let res = await userService.updateUserSocialMedia(this.userInfo.id,this.socialLinks)
      console.log(res)
    },
    DetectCloseModal(){
      this.socialLinks.github_url = this.userInfo.github_url
      this.socialLinks.facebook_url = this.userInfo.facebook_url
      this.socialLinks.instagram_url = this.userInfo.instagram_url
      this.socialLinks.linkedin_url = this.userInfo.linkedin_url
    }
  }
}
</script>

<style>

</style>