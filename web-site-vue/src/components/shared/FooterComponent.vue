<template>
  <footer class="footer fixed-bottom w-100 p-1 bg-primary">
    <b-row class="text-center" align-v="center">
      <b-col>
        <h3 class="font-weight-bold text-white">ATEC <span class="h6"> {{ new Date().getFullYear() }} </span> </h3>
      </b-col>
      <b-col>
      </b-col>
      <b-col>
        <b-row align-v="center">
          <b-col sm>
            <a target="_blank" class="text-white" href="https://www.youtube.com/user/ATECAcademiaFormacao">
              <b-icon-youtube></b-icon-youtube>
            </a>
          </b-col>
          <b-col sm>
            <a target="_blank" class="text-white" href="https://www.facebook.com/ATEC.AcademiadeFormacao">
              <b-icon-facebook></b-icon-facebook>
            </a>
          </b-col>
          <b-col sm>
            <a target="_blank" class="text-white" href="https://www.linkedin.com/company/atec">
              <b-icon-linkedin></b-icon-linkedin>
            </a>
          </b-col>
          <b-col sm>
            <a target="_blank" class="text-white" href="https://www.instagram.com/atec_academiadeformacao/?hl=pt">
              <b-icon-instagram></b-icon-instagram>
            </a>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </footer>
</template>

<script>
export default {
  name: "footer-component",
};
</script>

<style scoped>
footer {
  bottom: 0;
}
</style>
