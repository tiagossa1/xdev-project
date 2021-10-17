<template>
  <div style="margin-bottom: 55px" class="container">
    <h5 class="mb-3 mt-4 font-weight-bold">{{ getGrettingsByTime }}, {{ this.user.name }}!</h5>
    <notifications-component
      :notifications="notifications"
    ></notifications-component>
    <hr />
    <h5 class="mb-3 font-weight-bold">Gestão de utilizadores</h5>
    <user-management-component></user-management-component>
    <h5 class="mb-3 font-weight-bold">Gestão de feedbacks</h5>
    <feedback-management-component></feedback-management-component>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import UserManagementComponent from "../components/moderation/UserManagementComponent.vue";
import NotificationsComponent from "../components/moderation/NotificationsComponent.vue";
import FeedbackManagementComponent from "../components/moderation/FeedbackManagementComponent.vue";

import notificationService from "../services/notificationService";

export default {
  name: "Moderation",
  components: {
    NotificationsComponent,
    UserManagementComponent,
    FeedbackManagementComponent,
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
    };
  },
  async mounted() {
    this.notifications = await notificationService.getNotifications();
  },
};
</script>
