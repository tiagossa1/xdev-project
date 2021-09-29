<template>
  <div class="container">
    <post-options-component></post-options-component>
    <post-component></post-component>
  </div>
</template>

<script>
import PostComponent from '../components/PostComponent.vue';
import PostOptionsComponent from '../components/PostOptionsComponent.vue';
export default {
  name: "Home",
  components: {PostComponent,PostOptionsComponent},
};
</script>
