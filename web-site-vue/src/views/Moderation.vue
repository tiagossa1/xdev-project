<template>
  <div class="w-75 m-auto" style="margin-bottom: 55px">
    <transition
      name="fade"
      enter-active-class="fadeInLeft"
      leave-active-class="fadeOutRight"
    >
      <div v-if="show">
        <h5 class="mb-3 mt-4 font-weight-bold">
          {{ getGrettingsByTime }}, {{ this.user.name }}!
        </h5>
        <notifications-component
          :notifications="notifications"
        ></notifications-component>
        <hr />
      </div>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeInLeft"
      leave-active-class="fadeOutRight"
    >
      <user-management-component
        v-if="!isSheriff && show"
      ></user-management-component>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeInLeft"
      leave-active-class="fadeOutRight"
    >
      <feedback-management-component
        v-if="!isSheriff && show"
      ></feedback-management-component>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeInLeft"
      leave-active-class="fadeOutRight"
    >
      <tags-management-component
        v-if="!isSheriff && show"
      ></tags-management-component>
    </transition>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import UserManagementComponent from "../components/moderation/UserManagementComponent.vue";
import NotificationsComponent from "../components/moderation/NotificationsComponent.vue";
import FeedbackManagementComponent from "../components/moderation/FeedbackManagementComponent.vue";
import TagsManagementComponent from "../components/moderation/TagsManagementComponent.vue";

import notificationService from "../services/notificationService";
import userService from "../services/userService";

export default {
  name: "Moderation",
  components: {
    NotificationsComponent,
    UserManagementComponent,
    FeedbackManagementComponent,
    TagsManagementComponent,
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    getGrettingsByTime() {
      const date = new Date();
      const hour = date.getHours();

      if (hour >= 6 && hour <= 12) {
        return "Bom dia";
      } else if (hour >= 13 && hour <= 20) {
        return "Boa tarde";
      } else {
        return "Boa noite";
      }
    },
  },
  data() {
    return {
      notifications: [],
      isSheriff: false,
      show: false,
    };
  },
  async mounted() {
    this.isSheriff = await userService.isSheriff();

    let notifications = await notificationService.getNotifications();
    this.notifications = notifications.filter(
      (n) => n.type.toLowerCase() === "newreport"
    );

    this.show = true;
  },
};
</script>
