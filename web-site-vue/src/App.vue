<template>
  <div style="margin-bottom: 55px" id="app">
    <navbar-component></navbar-component>
    <b-alert
      :show="dismissCountDown"
      dismissible
      :variant="alertOptions.variant"
      @dismissed="dismissCountDown = 0"
      @dismiss-count-down="countDownChanged"
    >
      {{ alertOptions.alertMessage }}
    </b-alert>

    <transition
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <router-view :key="$route.fullPath" />
    </transition>
    <footer-component></footer-component>
  </div>
</template>

<script>
import FooterComponent from "./components/shared/FooterComponent.vue";
import NavbarComponent from "./components/shared/NavbarComponent.vue";

export default {
  name: "Register",
  components: { NavbarComponent, FooterComponent },
  mounted() {
    this.$root.$on("show-alert", (alertOptions) => {
      this.alertOptions.alertMessage = alertOptions.alertMessage;
      this.alertOptions.variant = alertOptions.variant;

      this.showAlert();
    });
  },
  data() {
    return {
      alertOptions: {
        alertMessage: "",
        variant: "",
      },
      dismissSecs: 5,
      dismissCountDown: 0,
    };
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
  },
  watch: {
    $route(to) {
      const DEFAULT_TITLE = "xDev";
      document.title = to.name ? `${DEFAULT_TITLE} - ${to.name}` : DEFAULT_TITLE;
    },
  },
};
</script>
