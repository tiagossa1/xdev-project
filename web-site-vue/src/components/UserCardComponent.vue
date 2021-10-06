<template>
    <b-card
      :img-alt="userInfo.name + ` photo`"
      img-top
      rounded="circle"
      img-src="https://picsum.photos/600/300/?image=25"
      tag="article"
      style="max-width: 20rem"
    >
    
      <b-card-body class="text-center p-0">
        <b-card-title :style="{color:userInfo.userType.hexColorCode}"> {{ userInfo.name }} </b-card-title>
        
        <b-badge class="m-0" :style="{backgroundColor:userInfo.userType.hexColorCode}">{{ userInfo.userType.name }} </b-badge>
        <b-card-sub-title class="m-2 p-0">{{userInfo.schoolClass.name}} | {{userInfo.schoolClass.school.name}} </b-card-sub-title>
        
    <b-card-group>
      <b-card border-variant="light" header="Posts" header-text-variant="primary">
      <b-card-text class="text-body" >{{userInfo.posts.length}}</b-card-text >
      </b-card>
    </b-card-group>

    <b-card-group class="mt-0">
      <b-card border-variant="light" header="Email" header-text-variant="primary">
      <b-card-text >
        <a class="text-body" :href="'mailto:' + userInfo.email">
          <b-icon icon="envelope-open" aria-hidden="true"></b-icon>
        </a>
      </b-card-text>
      </b-card>
    </b-card-group>

    <b-card-group class="mt-0">
      <b-card border-variant="light" header="Interesses" header-text-variant="primary">
      <b-card-text>
        {{userInfo.tags}}
      </b-card-text>
      </b-card>
    </b-card-group>
    </b-card-body>

      <div class="position-absolute bg-primary text-white rounded p-1 w-75 text-center m-auto">
        <b-container >
          <b-row>
            <b-col>
              <a class="text-white" :href="userInfo.facebook_url" target="_blank">
                <b-icon class="w-22" icon="facebook" aria-hidden="true"></b-icon>
              </a>
            </b-col>
            <b-col>
              <a class="text-white" :href="userInfo.linkedin_url" target="_blank">
                <b-icon class="w-22" icon="linkedin" aria-hidden="true"></b-icon>
              </a>
            </b-col>
            <b-col>
              <a class="text-white" :href="userInfo.gitgub_url" target="_blank">
                <b-icon class="w-22" icon="github" aria-hidden="true"></b-icon>
              </a>
            </b-col>
            <b-col>
              <a class="text-white" :href="userInfo.instagram_url" target="_blank">
                <b-icon class="w-22" icon="instagram" aria-hidden="true"></b-icon>
              </a>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </b-card>
</template>

<script>
import userService from "../services/userService";
//import postService from "../services/postService";

export default {
  name: "user-card-component",
  data() {
    return {
      userInfo: {},
      getTotalUserPosts: 0
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
};
</script>

<style>
</style>