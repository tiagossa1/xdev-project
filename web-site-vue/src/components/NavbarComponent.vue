<template>
  <b-navbar toggleable="lg" type="dark" class="bg-primary">
    <b-navbar-brand to="/home">
      <img
        to="/home"
        style="width: 6rem"
        src="@/assets/logo.png"
        alt="xDev Logo"
      />
    </b-navbar-brand>

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
                  <b-icon icon="search"></b-icon> Filtrar por tags
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
                  :key="option.id"
                  @click="onOptionClick({ option, addTag })"
                >
                  {{ option.name }} <b-badge class="float-right text-white" pill variant="primary">{{option.postsCount}}</b-badge>
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
          <b-nav-item-dropdown left>
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
                :src="'data:image/jpeg;base64,' + user.profile_picture"
                :style="{ border: '3px solid ' + user.user_type.hexColorCode }"
              >
              </b-avatar>
            </template>
            <b-dropdown-item v-if="notifications.length > 0" disabled
              >Tem {{ notifications.length }} notificações.
            </b-dropdown-item>
            <b-dropdown-item to="/profile">O meu perfil</b-dropdown-item>
            <b-dropdown-item to="/moderation" v-if="this.isModerator"
              >Moderação</b-dropdown-item
            >
            <!-- <b-dropdown-item @click="showModal()"
              >Configurações</b-dropdown-item
            > -->
            <b-dropdown-item @click="showFeedbackModal()"
              >Feedback</b-dropdown-item
            >
            <b-dropdown-item @click.prevent="signOut">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
          <div class="align-self-center" v-b-toggle.sidebar-1>
            <b-icon
              class="text-white"
              style="cursor: pointer"
              icon="bell"
              font-scale="2"
            ></b-icon>
            <b-badge class="ml-1" pill variant="light">
              {{ notifications.length }}
            </b-badge>
          </div>
          <b-sidebar
            id="sidebar-1"
            title="Notificações"
            backdrop-variant="dark"
            backdrop
            right
            shadow
          >
            <template v-if="notifications.length > 0">
              <transition-group name="fade" tag="div">
                <div
                  v-for="(notification, index) in notifications"
                  :key="notification.id"
                >
                  <b-card no-body class="text-center p-4">
                    <b-card-text>
                      <span
                        :style="{
                          color: notification.user.userType.hexColorCode,
                        }"
                        >{{ notification.user.name }}</span
                      >
                      criou um novo post sobre
                      {{ notification.tags.map((t) => t.name).join(", ") }}!
                      <br />
                      <!-- <b-button v-b-modal.modal-post-notification>Show Modal</b-button> -->
                      <b-link v-b-modal.modal-post-notification href=""
                        >Ver</b-link
                      >
                      <b-modal
                        id="modal-post-notification"
                        ok-only
                        @ok="removeNotification(index)"
                        @close="removeNotification(index)"
                        size="xl"
                        title="Novo Post"
                      >
                        <post-component
                          class="w-75 m-auto"
                          :post="notification"
                        ></post-component>
                      </b-modal>
                    </b-card-text>
                  </b-card>
                </div>
              </transition-group>
            </template>
            <template v-else>
              <table class="h-100 w-100">
                <tbody>
                  <tr>
                    <td class="text-center align-middle">Sem notificações.</td>
                  </tr>
                </tbody>
              </table>
            </template>
          </b-sidebar>
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

      
      <feedback ref="feedbackComponent" />
    </b-collapse>
  </b-navbar>
</template>

<script>
import tagService from "../services/tagService.js";
import notificationService from "../services/notificationService";

import Post from "../models/post";

import PostComponent from "./PostComponent.vue";

import Feedback from "./FeedbackComponent.vue";

import { mapGetters, mapActions } from "vuex";

export default {
  name: "navbar-component",
  components: {
    Feedback,
    PostComponent,
  },
  data() {
    return {
      value: [],
      options: [],
      tags: [],
      search: "",
      notifications: [],
      notificationCounter: 0,
      isModerator: false,
    };
  },
  async created() {
    if (this.authenticated) {
      const moderators = [2, 3, 4];
      const userTypeId = this.$store.getters["auth/user"].user_type.id
      this.isModerator = moderators.includes(userTypeId);

      let tags = await tagService.getTags();
      this.tags = tags;
      console.log(tags)
      this.options = tags;

      var channel = this.$pusher.subscribe("xdev");

      channel.bind("post-created", ({ post }) => {
        const userTagIds = this.$store.getters["auth/user"].tags.map(
          (ut) => ut.id
        );
        const postTagIds = post.tags.map((t) => t.id);

        if (
          post.user.id !== this.$store.getters["auth/user"].id &&
          postTagIds.some((pt) => userTagIds.includes(pt))
        ) {
          const postCreated = new Post(post);

          this.notifications.push(postCreated);
          this.notificationCounter++;
        }
      });
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
    async getPostNotifications() {
      // TODO: Create a filter on PostController.

      let notifications = await notificationService.getNotifications();
      return notifications.filter((n) => n.type.toLowerCase() === "newpost");
    },
    // showModal() {
    //   this.$refs.modalComponent.show();
    // },
    showFeedbackModal() {
      this.$refs.feedbackComponent.show();
    },
    onOptionClick({ option, addTag }) {
      addTag(option.name);
      this.value.push(option.name);
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
    removeNotification(index) {
      this.notifications.splice(index, 1);
    },
    async markAsRead(notificationId) {
      let res = await notificationService
        .markAsRead(notificationId)
        .catch((err) => console.log(err.response.data));

      if (res.status === 200) {
        let indexToRemove = this.notifications.findIndex(
          (n) => n.id === notificationId
        );

        if (indexToRemove > -1) {
          this.notifications.splice(indexToRemove, 1);
        }
      }
    },
  },
};
</script>

<style>
.my-class .dropdown-menu {
  max-height: 15rem;
  overflow-y: auto;
}
