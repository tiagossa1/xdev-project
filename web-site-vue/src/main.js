import Vue from "vue";
import App from "./App.vue";
import Vuelidate from "vuelidate";
import axios from "axios";
import VueAxios from "vue-axios";
import VueCompositionAPI from "@vue/composition-api";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import store from "./store";
// import subscribe from './store/subscribe';

import "./styles/_variables.scss";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import router from "./router";

require("@/store/subscriber");

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuelidate);

Vue.use(VueAxios, axios);

Vue.use(VueCompositionAPI);

Vue.config.productionTip = false;

store
  .dispatch("auth/attempt", {
    user: JSON.parse(localStorage.getItem("user")),
    token: localStorage.getItem("token"),
  })
  .then(() => {
    new Vue({
      router,
      render: (h) => h(App),
      store: store,
    }).$mount("#app");
  });
