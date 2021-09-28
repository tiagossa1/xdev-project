<template>
  <div class="container">
    <post-component></post-component>
  </div>
</template>

<script>
import PostComponent from '../components/PostComponent.vue';
export default {
  name: "Home",
  components: {PostComponent},
};
</script>
