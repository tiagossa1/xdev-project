<template>
  <div class="home">
    <register-component></register-component>
  </div>
</template>

<script>
import RegisterComponent from "../components/RegisterComponent.vue";

export default {
  name: "Register",
  components: { RegisterComponent },
};
</script>
