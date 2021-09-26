<template>
  <div id="app">
    <navbar-component></navbar-component>
    <router-view />
    <footer-component></footer-component>
  </div>
</template>

<script>
import FooterComponent from "./components/FooterComponent.vue";
import NavbarComponent from "./components/NavbarComponent.vue";

export default {
  name: "Register",
  components: { NavbarComponent, FooterComponent },
  watch: {
    $route(to) {
      const DEFAULT_TITLE = "xDev";
      document.title = `${DEFAULT_TITLE} - ${to.name}` || DEFAULT_TITLE;
    },
  },
};
</script>
