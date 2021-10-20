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
        <template v-if="authenticated && isHome">
          <b-form-tags
            id="tags-with-dropdown"
            v-model="value"
            no-outer-focus
            class="mb-2"
            style="width: 30rem"
          >
            <template v-slot="{ tags, disabled, addTag, removeTag }">
              <ul
                v-if="tags.length > 0"
                class="list-inline d-inline-block mb-2"
              >
                <li v-for="tag in tags" :key="tag" class="list-inline-item">
                  <b-form-tag
                    @remove="
                      removeTag(tag);
                      onRemove(tag);
                    "
                    :title="tag"
                    :disabled="disabled"
                    variant="primary"
                    class="text-white"
                    >{{ tag }}</b-form-tag
                  >
                </li>
              </ul>

              <b-dropdown
                size="sm"
                variant="outline-secondary"
                block
                menu-class="w-100"
                class="my-class"
              >
                <template #button-content>
                  <b-icon icon="tag-fill"></b-icon> Filtrar por tags
                </template>
                <b-dropdown-form @submit.stop.prevent="() => {}">
                  <b-form-group
                    label="Procurar tag"
                    label-for="tag-search-input"
                    label-cols-md="auto"
                    class="mb-0"
                    label-size="sm"
                    :description="searchDesc"
                    :disabled="disabled"
                  >
                    <b-form-input
                      v-model="search"
                      id="tag-search-input"
                      type="search"
                      size="sm"
                      autocomplete="off"
                    ></b-form-input>
                  </b-form-group>
                </b-dropdown-form>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item-button
                  v-for="option in availableOptions"
                  :key="option"
                  @click="onOptionClick({ option, addTag })"
                >
                  {{ option }}
                </b-dropdown-item-button>
                <b-dropdown-text v-if="availableOptions.length === 0">
                  Não existem tags para selecionar
                </b-dropdown-text>
              </b-dropdown>
            </template>
          </b-form-tags>
        </template>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <template v-if="authenticated">
          <b-nav-item-dropdown right>
            <template #button-content>
              <b-badge
                class="mr-2 p-1"
                :style="{
                  backgroundColor: user.user_type.hexColorCode,
                }"
              >
                {{ user.name }}
              </b-badge>
              <b-avatar
                :badge="notificationCount"
                :src="'data:image/jpeg;base64,' + user.profile_picture"
                :style="{ border: '3px solid ' + user.user_type.hexColorCode }"
                badge-variant="primary"
              >
              </b-avatar>
            </template>
            <b-dropdown-item v-if="notificationCount > 0" disabled
              >Tem {{ notificationCount }} notificações.
            </b-dropdown-item>
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
import notificationService from "../services/notificationService";

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
      tags: [],
      search: "",
      notificationCount: "0",
    };
  },
  async mounted() {
    if (this.authenticated) {
      this.notificationCount = await this.getNotificationsCount();

      window.setInterval(async () => {
        this.notificationCount = await this.getNotificationsCount();
      }, 10000);
    }
  },
  async created() {
    if (this.authenticated) {
      let tags = await tagService.getTags();
      this.tags = tags;
      this.options = tags.map((t) => t.name).sort();
    }
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
    availableOptions() {
      const criteria = this.criteria;
      const options = this.options.filter(
        (opt) => this.value.indexOf(opt) === -1
      );

      if (criteria) {
        return options.filter(
          (opt) => opt.toLowerCase().indexOf(criteria) > -1
        );
      }

      return options;
    },
    searchDesc() {
      if (this.criteria && this.availableOptions.length === 0) {
        return "Não foram encontradas tags.";
      }
      return "";
    },
    isModerator() {
      return this.user.user_type.id === 2 || this.user.user_type.id === 4;
    },
    criteria() {
      return this.search.trim().toLowerCase();
    },
    isHome() {
      return this.$route.name === "Home";
    },
  },
  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
    }),
    getBadgeStyle() {
      return {
        color: "white",
        backgroundColor: this.user.user_type.hexColorCode,
      };
    },
    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("Login").catch(() => {});
      });
    },
    async getNotificationsCount() {
      let notifications = await notificationService.getNotifications();
      return notifications.length.toString();
    },
    showModal() {
      this.$refs.modalComponent.show();
    },
    onOptionClick({ option, addTag }) {
      addTag(option);
      this.value.push(option);
      this.search = "";

      this.emitEventToSearchByTags();
    },
    emitEventToSearchByTags() {
      if (this.value.length == 0) {
        this.$root.$emit("tag-search-navbar", []);
      } else {
        let tagIds = this.tags
          .filter((t) => this.value.includes(t.name))
          .map((t) => t.id);
        this.$root.$emit("tag-search-navbar", tagIds);
      }
    },
    onRemove(tag) {
      const index = this.value.indexOf(tag);
      if (index > -1) {
        this.value.splice(index, 1);
      }

      this.emitEventToSearchByTags();
    },
  },
};
</script>

<style>
.my-class .dropdown-menu {
  max-height: 15rem;
  overflow-y: auto;
}
