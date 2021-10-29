<template>
  <div class="w-75">
    <b-card
      :img-alt="userInfo.name + ` photo`"
      img-top
      rounded="circle"
      :img-src="userInfo.profile_picture"
      tag="article"
      style="max-width: 20rem; border-radius: 10px"
    >
      <b-card-body class="text-center p-0">
        <b-icon
          v-if="!paramId"
          class="ml-2 mt-2 cursor-pointer float-right"
          scale="1"
          icon="pencil"
          @click="showModal()"
        ></b-icon>
        <b-card-title
          class="font-weight-bold h5"
          :style="{ color: userInfo.userType.hexColorCode }"
        >
          <span>
            {{ userInfo.name }}
          </span>
          <br />
          <b-badge :style="{ backgroundColor: userInfo.userType.hexColorCode }"
            >{{ userInfo.userType.name }}
          </b-badge>
        </b-card-title>
        <b-card-sub-title class="mt-3 mb-3 small"
          >{{ userInfo.schoolClass.name }} |
          {{ userInfo.schoolClass.school.name }}
        </b-card-sub-title>

        <b-card-group class="mb-3">
          <b-card border-variant="light">
            <template #header>
              <span class="font-weight-bold text-primary">Posts</span>
            </template>
            <b-card-text class="text-body">{{ postCount }}</b-card-text>
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
              <b-badge
                class="m-2 text-white p-2"
                v-for="tag in userInfo.tags"
                :key="tag.id"
                pill
                variant="primary"
              >
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
                    <a
                      class="text-dark"
                      target="_blank"
                      :href="'http://' + userInfo.facebook_url"
                    >
                      <b-icon
                        class="w-22"
                        icon="facebook"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a
                      class="text-dark"
                      target="_blank"
                      :href="'http://' + userInfo.linkedin_url"
                    >
                      <b-icon
                        class="w-22"
                        icon="linkedin"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a
                      class="text-dark"
                      target="_blank"
                      :href="'http://' + userInfo.github_url"
                    >
                      <b-icon
                        class="w-22"
                        icon="github"
                        aria-hidden="true"
                      ></b-icon>
                    </a>
                  </b-col>
                  <b-col>
                    <a
                      class="text-dark"
                      target="_blank"
                      :href="'http://' + userInfo.instagram_url"
                    >
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
    <user-settings ref="modalComponent" />
  </div>
</template>

<script>
import UserSettings from "./UserSettingsComponent.vue";
export default {
  name: "user-card-component",
  components: {
    UserSettings,
  },
  props: {
    userInfo: Object,
    postCount: Number,
  },
  data() {
    return {
      paramId: null,
    };
  },
  async created() {
    this.paramId = this.$route.params.id;
  },
  methods: {
    showModal() {
      this.$refs.modalComponent.show();
    },
  },
};
</script>

<style>
</style>