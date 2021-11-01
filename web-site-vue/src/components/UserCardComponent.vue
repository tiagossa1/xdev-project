<template>
  <div>
    <div class="text-center">
      <b-icon
        v-if="!paramId"
        class=" mt-3 mr-3 cursor-pointer float-right"
        scale="1"
        icon="pencil"
        @click="showModal()"
      ></b-icon>
      <div class="bg-white rounded py-5 px-4" style="border-radious: 10px">
        <b-avatar :src="propUserInfo.profile_picture" size="12rem"> </b-avatar>
        <h2
          class="mt-2 font-weight-bold"
          :style="{ color: propUserInfo.userType.hexColorCode }"
        >
          {{ propUserInfo.name }}
        </h2>

        <h5>
          <b-badge
            :style="{ backgroundColor: propUserInfo.userType.hexColorCode }"
            >{{ propUserInfo.userType.name }}
          </b-badge>
        </h5>
        <span>
          {{ propUserInfo.schoolClass.name }} |
          {{ propUserInfo.schoolClass.school.name }}
        </span>
        <hr />
        <b-row>
          <b-col class="col-xs-4">
            <div>
              <h5 class="font-weight-bold text-primary">Email</h5>

              <a class="text-body" :href="'mailto:' + propUserInfo.email">
                <b-icon icon="envelope-open" aria-hidden="true"></b-icon>
              </a>
            </div>
          </b-col>
        </b-row>

        <hr />

        <b-row>
          <b-col class="profile-overview">
            <h5 class="font-weight-bold text-primary">Posts</h5>
            <span class="text-body">{{ postCount }}</span>
          </b-col>
        </b-row>

        <hr />

        <b-row>
          <b-col>
            <h5 class="font-weight-bold text-primary">Interesses</h5>
          </b-col>
        </b-row>
        <b-row>
          <b-col v-if="propUserInfo.tags.length > 0">
            <b-badge
              class="m-2 text-white p-2"
              v-for="tag in propUserInfo.tags"
              :key="tag.id"
              pill
              variant="primary"
            >
              {{ tag.name }}
            </b-badge>
          </b-col>

          <b-col v-else>
            <span>Sem interesses</span>
          </b-col>
        </b-row>

        <hr />

        <b-row>
          <b-col>
            <h5 class="font-weight-bold text-primary">Redes Sociais</h5>
          </b-col>
        </b-row>

        <b-row class="mt-3">
          <b-col>
            <a target="_blank" :href="propUserInfo.facebook_url">
              <b-img
                height="20"
                width="20"
                src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/facebook/facebook-original.svg"
              ></b-img>
            </a>
          </b-col>
          <b-col>
            <a target="_blank" :href="propUserInfo.linkedin_url">
              <b-img
                height="20"
                width="20"
                src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg"
              ></b-img>
            </a>
          </b-col>
          <b-col>
            <a target="_blank" :href="propUserInfo.github_url">
              <b-img
                height="20"
                width="20"
                src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg"
              ></b-img>
            </a>
          </b-col>
          <b-col>
            <a target="_blank" :href="propUserInfo.instagram_url">
              <b-img
                height="20"
                width="20"
                src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
              ></b-img>
            </a>
          </b-col>
        </b-row>
      </div>
      <user-settings
        ref="modalComponent"
        @on-social-media-update="onSocialMediaUpdate"
      />
    </div>
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
      propUserInfo: this.userInfo,
    };
  },
  async created() {
    this.paramId = this.$route.params.id;
  },
  methods: {
    showModal() {
      this.$refs.modalComponent.show();
    },
    onSocialMediaUpdate(user) {
      this.propUserInfo = user;
    },
  },
};
</script>
