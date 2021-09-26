import Vue from "vue";
import App from "./App.vue";
import Vuelidate from "vuelidate";
import axios from "axios";
import VueAxios from "vue-axios";
import VueCompositionAPI from "@vue/composition-api";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

import "./styles/_variables.scss";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import router from "./router";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuelidate);
Vue.use(VueAxios, axios);
Vue.use(VueCompositionAPI);

Vue.config.productionTip = false;

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
