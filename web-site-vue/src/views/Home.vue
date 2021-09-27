<template>
  <div class="container">
    <div class="buttons m-3">
      <b-button pill variant="info">Criar +</b-button>
      <b-dropdown class="ml-2" id="dropdown-1" text="Filtro">
        <b-dropdown-item >First Action</b-dropdown-item>
      </b-dropdown>
    </div>
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
