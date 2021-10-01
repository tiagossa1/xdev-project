<template>
  <footer class="navbar">
    <div>
      <h2 class="float-left font-weight-bold">ATEC</h2>
      <span class="ml-2 small">© {{ new Date().getFullYear() }}</span>
    </div>
  </footer>
</template>

<script>
export default {
  name: "footer-component",
  mounted() {
    console.log("Footer component mounted.");
  },
};
</script>

<style scoped>
footer {
    background-color: #32B9F9;
  height: 60px; /* Height of the footer */
}
</style>

