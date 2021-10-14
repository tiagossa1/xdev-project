<template>
  <div style="margin-bottom: 55px" class="container">
    <b-table :fields="fields" :items="notifications">
      <template #cell(postTitle)="data">
        <a
          v-b-modal.post-modal
          :ref="data.item.post.id"
          href=""
          @click.prevent="setPost(data.item.post)"
          >{{ data.value }}</a
        >
      </template>
      <template #cell(userName)="data">
        <a target="_blank" :href="'/profile/' + data.item.userId">
          {{ data.value }}
        </a>
      </template>
    </b-table>

    <b-modal id="post-modal" size="xl" title="Post reportado">
      <post-component class="w-75 m-auto" :post="postSelected" :viewOnly="true"></post-component>
    </b-modal>
  </div>
</template>

<script>
import PostComponent from "../components/PostComponent.vue";

import notificationService from "../services/notificationService";

export default {
  name: "Moderation",
  components: { PostComponent },
  data() {
    return {
      fields: [
        {
          key: "id",
          label: "Report ID",
        },
        {
          key: "userName",
          label: "Reportado por",
        },
        {
          key: "postTitle",
          label: "Post reportado",
        },
        {
          key: "reason",
          label: "Razão",
        },
      ],
      notifications: [],
      postSelected: {},
    };
  },
  async mounted() {
    this.notifications = await notificationService.getNotifications();
    console.log(this.notifications);
  },
  methods: {
    setPost(post) {
      this.postSelected = post;
    },
  },
};
</script>
