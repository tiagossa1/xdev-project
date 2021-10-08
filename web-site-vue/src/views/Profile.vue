<template>
  <b-container fluid>
    <b-row>
      <b-col class="p-5">
        <user-card-component></user-card-component>
      </b-col>

      <b-col>
        <div v-for="post in userInfo.posts" :key="post.id">
          <post-component :post="post"></post-component>
        </div>
      </b-col>

      <b-col> </b-col>
    </b-row>
  </b-container>
</template>

<script>
import userService from "../services/userService";
import UserCardComponent from "../components/UserCardComponent.vue";
import User from '../models/user';
export default {
  name: "Profile",
  components: { UserCardComponent },
  data() {
    return {
      userInfo: User,
    };
  },
  async mounted() {
    const paramId = this.$route.params.id;

    if (paramId) {
      this.userInfo = await userService.getUserById(paramId);
    } else {
      this.userInfo = await userService.getUserById(
        this.$store.getters["auth/user"].id
      );
    }
  },
};
</script>

<style>
</style>