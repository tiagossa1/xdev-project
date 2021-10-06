<template>
<b-container fluid>
  <b-row >

    <b-col class="p-5">
        <user-card-component></user-card-component>
    </b-col>

    <b-col>
        <div v-for="post in userInfo.posts" :key="post.id">
            <post-component
                :post="post"
            ></post-component>
        </div>
    </b-col>

    <b-col>

    </b-col>

    </b-row>
  </b-container>
</template>

<script>
import userService from "../services/userService";
//import PostComponent from "../components/PostComponent.vue";
import UserCardComponent from "../components/UserCardComponent.vue";
export default {
    name: "Profile",
    components: { UserCardComponent },
    data() {
        return {

            userInfo: {},
        };
    },
    async mounted() {
    this.userInfo = await userService
      .getUserById(this.$store.getters["auth/user"].id);

      console.log(this.userInfo);
    
    /*this.getTotalUserPosts = await postControler
    .getTotalPostsByUserId(this.$store.getters["auth/user"].id);

    console.log(this.getTotalUserPosts);*/
  },
}
</script>

<style>

</style>