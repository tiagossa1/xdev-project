<template>
  <div class="w-75 m-auto" style="margin-bottom: 55px">
    <transition
      name="fade"
      enter-active-class="fadeIn"
      leave-active-class="fadeOut"
    >
      <div v-if="show">
        <h5 class="mb-3 mt-4 text-center font-weight-bold">
          {{ getGrettingsByTime }}, {{ this.user.name }}!
        </h5>
        <report-management-component
          v-if="!isSheriff && show"
        ></report-management-component>
        <hr />
      </div>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeIn"
      leave-active-class="fadeOut"
    >
      <user-management-component
        v-if="!isSheriff && show"
      ></user-management-component>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeIn"
      leave-active-class="fadeOut"
    >
      <feedback-management-component
        v-if="!isSheriff && show"
      ></feedback-management-component>
    </transition>

    <transition
      name="fade"
      enter-active-class="fadeIn"
      leave-active-class="fadeOut"
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
import ReportManagementComponent from "../components/moderation/ReportManagementComponent.vue";
// import NotificationsComponent from "../components/moderation/NotificationsComponent.vue";
import FeedbackManagementComponent from "../components/moderation/FeedbackManagementComponent.vue";
import TagsManagementComponent from "../components/moderation/TagsManagementComponent.vue";

import notificationService from "../services/notificationService";
import userService from "../services/userService";

export default {
  name: "Moderation",
  components: {
    ReportManagementComponent,
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
