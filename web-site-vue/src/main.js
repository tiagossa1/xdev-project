import Vue from "vue";
import App from "./App.vue";
import Vuelidate from "vuelidate";
import axios from "axios";
import VueAxios from "vue-axios";
import VueCompositionAPI from "@vue/composition-api";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import store from "./store";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import router from "./router";

require("@/store/subscriber");

import './styles/app.scss';
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuelidate);

Vue.use(VueAxios, axios);

Vue.use(VueCompositionAPI);

Vue.config.productionTip = false;

//var dayjs = require('dayjs')
//dayjs().format()
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import updateLocale  from 'dayjs/plugin/updateLocale'
//var relativeTime = require('dayjs/plugin/relativeTime')
dayjs.extend(relativeTime)
dayjs.extend(updateLocale)
dayjs.updateLocale('en', {
  relativeTime: {
    future: "em %s",
    past: "há %s",
    s: 'alguns segundos',
    m: "1 minuto",
    mm: "há %d minutos",
    h: "1 hora",
    hh: "%d horas",
    d: "dia",
    dd: "%d dias",
    M: "1 mês",
    MM: "%d meses",
    y: "1 ano",
    yy: "%d anos"
  }
})
Vue.use(dayjs);

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
