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
              >
                <template #button-content>
                  <b-icon icon="search"></b-icon> Filtrar por tags
                </template>
                <b-dropdown-form>
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
                <div class="scrollable-select">
                  <b-dropdown-item-button
                    v-for="option in availableOptions"
                    :key="option.id"
                    @click="onOptionClick({ option, addTag })"
                  >
                    {{ option.name }}
                    <b-badge
                      class="float-right text-white"
                      pill
                      variant="primary"
                      >{{ option.postsCount }}</b-badge
                    >
                  </b-dropdown-item-button>
                </div>
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
          <div class="align-self-center mr-2" v-b-toggle.sidebar-1>
            <b-badge
              v-if="notifications.length > 0"
              class="mr-1"
              style="vertical-align: text-top"
              pill
              variant="light"
            >
              {{ notifications.length }}
            </b-badge>
            <b-icon
              :class="notifications.length > 0 ? 'text-danger' : 'text-white'"
              style="cursor: pointer"
              icon="bell"
              font-scale="2"
            ></b-icon>
          </div>
          <b-nav-item-dropdown right>
            <template #button-content>
              <b-avatar
                :src="user.profile_picture"
                :style="{ border: '3px solid ' + user.user_type.hexColorCode }"
              >
              </b-avatar>
              <b-badge
                class="ml-2 p-1"
                :style="{
                  backgroundColor: user.user_type.hexColorCode,
                }"
              >
                {{ user.name }}
              </b-badge>
            </template>
            <b-dropdown-item v-if="notifications.length > 0" disabled
              >Tem {{ notifications.length }} notificações.
            </b-dropdown-item>
            <b-dropdown-item to="/profile">
              <b-icon-person-fill
                class="mr-1 align-middle"
                font-scale="0.9"
              ></b-icon-person-fill>
              O meu perfil</b-dropdown-item
            >
            <b-dropdown-item to="/moderation" v-if="this.isModerator">
              <b-icon-exclamation-circle-fill
                class="mr-1 align-middle"
                font-scale="0.9"
              ></b-icon-exclamation-circle-fill>
              Moderação</b-dropdown-item
            >
            <b-dropdown-item @click="showFeedbackModal()">
              <b-icon-chat-fill
                class="mr-1 align-middle"
                font-scale="0.9"
              ></b-icon-chat-fill>
              Feedback</b-dropdown-item
            >
            <b-dropdown-item @click.prevent="signOut">
              <b-icon-arrow-left
                class="mr-1 align-middle"
                font-scale="0.9"
              ></b-icon-arrow-left>
              Sair</b-dropdown-item
            >
          </b-nav-item-dropdown>
          <b-sidebar
            id="sidebar-1"
            title="Notificações"
            backdrop-variant="dark"
            backdrop
            right
            shadow
          >
            <template v-if="notifications.length > 0">
              <div
                v-for="(notification, index) in notifications"
                :key="notification.id"
              >
                <template v-if="notification.constructor.name === 'Post'">
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
                </template>
                <template
                  v-else-if="notification.constructor.name === 'Report'"
                >
                  <b-card no-body class="text-center p-4">
                    <b-card-text>
                      <span
                        :style="{
                          color: notification.user.userType.hexColorCode,
                        }"
                        >{{ notification.user.name }}</span
                      >
                      criou um novo report. Para o ver, entre na
                      <b-link to="/moderation">página de moderação</b-link>.
                    </b-card-text>
                  </b-card>
                </template>
              </div>
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
import tagService from "../../services/tagService.js";
import notificationService from "../../services/notificationService";

import Post from "../../models/post";

import PostComponent from "../PostComponent.vue";

import Feedback from "../FeedbackComponent.vue";

import { mapGetters, mapActions } from "vuex";
import userService from "../../services/userService.js";
import reportService from "../../services/reportService.js";

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
    };
  },
  async created() {
    if (this.authenticated) {
      let tags = await tagService.getTags();
      this.tags = tags;
      this.options = tags;

      var channel = this.$pusher.subscribe(
        process.env.VUE_APP_PUSHER_CHANNEL_NAME
      );

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

      channel.bind("report-created", async ({ id }) => {
        const isModerator = await userService.isModerator();

        if (isModerator) {
          const reportCreated = await reportService.getById(id);

          if (reportCreated.user.id !== this.user.id) {
            this.notifications.push(reportCreated);
            this.notificationCounter++;
          }
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
          (opt) => opt.name.toLowerCase().indexOf(criteria) > -1
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
    isModerator() {
      const moderators = [2, 3, 4];
      const userTypeId = this.$store.getters["auth/user"].user_type.id;
      return moderators.includes(userTypeId);
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
    showFeedbackModal() {
      this.$refs.feedbackComponent.show();
    },
    onOptionClick({ option, addTag }) {
      addTag(option.name);
      this.value.push(option.name);
      this.search = "";

      this.emitEventToSearchByTags();
    },
    onRemove(tag) {
      const index = this.value.indexOf(tag);
      if (index > -1) {
        this.value.splice(index, 1);
      }

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
    removeNotification(index) {
      this.notifications.splice(index, 1);
    },
    async markAsRead(notificationId) {
      let res = await notificationService
        .markAsRead(notificationId)
        .catch((err) => {
          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: err.response.data,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

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
.scrollable-select {
  height: 25rem;
  overflow: auto;
}
</style>
