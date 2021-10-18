<template>
  <b-card-group deck class="mb-3 text-center">
    <b-card border-variant="light">
      <template #header>
        <span class="font-weight-bold text-primary">Tags Populares</span>
        <b-icon-x
          @click="clearFilter"
          v-if="showClearButton"
          style="cursor: pointer"
          class="text-danger"
        ></b-icon-x>
      </template>
      <b-card-text>
        <div v-for="(filteringTag, i) in filteringBy" :key="'filteringTag, ' + i">
          {{ filteringTag }}
        </div>
        <b-badge
          v-for="popularTag in popularTags"
          @click="emitEventForSearch(popularTag)"
          href="#"
          class="m-2 text-white p-2"
          pill
          variant="primary"
          :key="popularTag.name"
        >
          {{ popularTag.name }}
        </b-badge>
      </b-card-text>
    </b-card>
  </b-card-group>
</template>

<script>
import tagService from "../services/tagService";
export default {
  name: "popularTags-component",
  data() {
    return {
      popularTags: null,
      filteringBy: [],
      showClearButton: false,
    };
  },
  async created() {
    this.popularTags = await tagService.getTagsByCount(5);
  },
  methods: {
    emitEventForSearch(tabObj) {
      if (!this.filteringBy.includes(tabObj.name)) {
        this.filteringBy.push(tabObj.name);
        this.$root.$emit("tag-search-navbar", [tabObj.id]);
        this.showClearButton = true;
      }
    },
    clearFilter() {
      this.filteringBy = [];
      this.$root.$emit("tag-search-navbar", []);
      this.showClearButton = false;
    },
  },
};
</script>

<style>
</style>