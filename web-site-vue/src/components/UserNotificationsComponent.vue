<template>
  <div>
    <template v-if="notifications.length > 0">
      <b-table striped hover :items="notifications"></b-table>
    </template>
    <template v-else>
      <div class="ml-5 mt-4">
        <p>Não há novos posts.</p>
      </div>
    </template>
  </div>
</template>

<script>
import notificationService from "../services/notificationService";

export default {
  name: "user-notifications-component",
  data() {
    return {
      notifications: [],
    };
  },
  mounted() {},
  async created() {
    this.notifications = await this.getNotifications();
  },
  methods: {
    async getNotifications() {
      let notifications = await notificationService.getNotifications();
      return notifications.filter((n) => n.type === "NewPost");
    },
  },
};
</script>
