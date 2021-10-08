<template>
  <div class="w-75">
    <b-card
      :img-alt="userInfo.name + ` photo`"
      img-top
      rounded="circle"
      img-src="https://picsum.photos/600/300/?image=25"
      tag="article"
      style="max-width: 20rem"
    >
      <b-card-body class="text-center p-0">
        <b-card-title
          class="font-weight-bold"
          :style="{ color: userInfo.userType.hexColorCode }"
        >
          {{ userInfo.name }}
          <b-badge :style="{ backgroundColor: userInfo.userType.hexColorCode }"
            >{{ userInfo.userType.name }}
          </b-badge>
        </b-card-title>
        <b-card-sub-title class="mt-3 mb-3"
          >{{ userInfo.schoolClass.name }} |
          {{ userInfo.schoolClass.school.name }}
        </b-card-sub-title>

        <b-card-group class="mb-3">
          <b-card border-variant="light">
            <template #header>
              <span class="font-weight-bold text-primary">Posts</span>
            </template>
            <b-card-text class="text-body">{{
              userInfo.posts.length
            }}</b-card-text>
          </b-card>
        </b-card-group>

        <b-card-group class="mb-3">
          <b-card border-variant="light">
            <template #header>
              <span class="font-weight-bold text-primary">Email</span>
            </template>
            <b-card-text>
              <a class="text-body" :href="'mailto:' + userInfo.email">
                <b-icon icon="envelope-open" aria-hidden="true"></b-icon>
              </a>
            </b-card-text>
          </b-card>
        </b-card-group>

        <b-card-group class="mb-3">
          <b-card border-variant="light">
            <template #header>
              <span class="font-weight-bold text-primary">Interesses</span>
            </template>
            <b-card-text v-if="userInfo.tags.length > 0">
              <b-badge class="m-2 text-white p-2" v-for="tag in userInfo.tags" :key="tag.id" pill variant="primary">
                {{ tag.name }}
              </b-badge>
            </b-card-text>
            <b-card-text v-else> Sem interesses </b-card-text>
          </b-card>
        </b-card-group>

        <b-card-group class="mb-3">
          <b-card border-variant="light">
            <template #header>
              <span class="font-weight-bold text-primary">Redes Sociais</span>
            </template>
            <b-card-text>
              <b-container>
                <b-row>
                  <b-col>
                    <a class="text-dark" :href="userInfo.facebook_url">
                      <b-icon
                        class="w-22"
                        icon="facebook"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a class="text-dark" :href="userInfo.linkedin_url">
                      <b-icon
                        class="w-22"
                        icon="linkedin"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a class="text-dark" :href="userInfo.github_url">
                      <b-icon
                        class="w-22"
                        icon="github"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a class="text-dark" :href="userInfo.instagram_url">
                      <b-icon
                        class="w-22"
                        icon="instagram"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                </b-row>
              </b-container>
            </b-card-text>
          </b-card>
        </b-card-group>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import User from '../models/user';

export default {
  name: "user-card-component",
  props: { userInfo: User},
};
</script>

<style>
</style>