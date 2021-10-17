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
            <!-- Prop `add-on-change` is needed to enable adding tags vie the `change` event -->
            <b-form-tags
              id="tags-component-select"
              v-model="value"
              size="lg"
              class="mb-2"
              style="width: 30rem"
              add-on-change
              no-outer-focus
            >
              <template
                v-slot="{
                  tags,
                  inputAttrs,
                  inputHandlers,
                  disabled,
                  removeTag,
                }"
              >
                <ul
                  v-if="tags.length > 0"
                  class="list-inline d-inline-block mb-2"
                >
                  <li v-for="tag in tags" :key="tag" class="list-inline-item">
                    <b-form-tag
                      @remove="removeTag(tag)"
                      class="text-white"
                      :title="tag"
                      :disabled="disabled"
                      variant="primary"
                      >{{ tag }}</b-form-tag
                    >
                  </li>
                </ul>
                <b-form-select
                  v-bind="inputAttrs"
                  v-on="inputHandlers"
                  :disabled="disabled || availableOptions.length === 0"
                  :options="availableOptions"
                  style="width: 28rem"
                >
                  <template #first>
                    <!-- This is required to prevent bugs with Safari -->
                    <option disabled value="">Escolha uma tag...</option>
                  </template>
                </b-form-select>
              </template>
            </b-form-tags>
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
              <b-avatar
                :src="'data:image/jpeg;base64,' + user.profile_picture"
              ></b-avatar>
            </template>
            <b-dropdown-item to="/profile">O meu perfil</b-dropdown-item>
            <b-dropdown-item to="/moderation" v-if="this.isModerator"
              >Moderação</b-dropdown-item
            >
            <b-dropdown-item @click="showModal()"
              >Configurações</b-dropdown-item
            >
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

      <user-settings ref="modalComponent" />
    </b-collapse>
  </b-navbar>
</template>

<script>
import tagService from "../services/tagService.js";

import { mapGetters, mapActions } from "vuex";
import UserSettings from "./UserSettingsComponent.vue";
export default {
  name: "navbar-component",
  components: {
    UserSettings,
  },
  data() {
    return {
      value: [],
      options: [],
    };
  },
  async created() {
    if (this.authenticated) {
      let tags = await tagService.getTags();
      this.options = tags.map((t) => t.name).sort();
    }
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
    availableOptions() {
      return this.options.filter((opt) => this.value.indexOf(opt) === -1);
    },
    isModerator() {
      return this.user.user_type.id === 2 || this.user.user_type.id === 4;
    },
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

    showModal() {
      this.$refs.modalComponent.show();
    },
  },
};
</script>
