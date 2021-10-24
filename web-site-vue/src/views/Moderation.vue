<template>
  <div class="w-75 m-auto" style="margin-bottom: 55px">
    <h5 class="mb-3 mt-4 font-weight-bold">
      {{ getGrettingsByTime }}, {{ this.user.name }}!
    </h5>
    <notifications-component
      :notifications="notifications"
    ></notifications-component>
    <hr />
    <user-management-component v-if="!isxSheriff"></user-management-component>
    <feedback-management-component v-if="!isxSheriff"></feedback-management-component>
    <tags-management-component v-if="!isxSheriff"></tags-management-component>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import UserManagementComponent from "../components/moderation/UserManagementComponent.vue";
import NotificationsComponent from "../components/moderation/NotificationsComponent.vue";
import FeedbackManagementComponent from "../components/moderation/FeedbackManagementComponent.vue";
import TagsManagementComponent from '../components/moderation/TagsManagementComponent.vue';

import notificationService from "../services/notificationService";
import userService from '../services/userService';

export default {
  name: "Moderation",
  components: {
    NotificationsComponent,
    UserManagementComponent,
    FeedbackManagementComponent,
    TagsManagementComponent
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
      isxSheriff: false
    };
  },
  async mounted() {
    this.isxSheriff = await userService.isxSheriff();
    
    let notifications = await notificationService.getNotifications();
    this.notifications = notifications.filter(
      (n) => n.type.toLowerCase() === "newreport"
    );
  },
};
</script>
