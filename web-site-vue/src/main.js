import Vue from "vue";
import App from "./App.vue";
import Vuelidate from "vuelidate";
import axios from "axios";
import VueAxios from "vue-axios";
import VueCompositionAPI from "@vue/composition-api";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import store from "./store";
import VueQuillEditor from "vue-quill-editor";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import router from "./router";

require("@/store/subscriber");

import "./styles/app.scss";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuelidate);
Vue.use(VueAxios, axios);
Vue.use(VueCompositionAPI);

import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
Vue.use(VueQuillEditor);

var filter = function(text, length, clamp) {
  clamp = clamp || "...";
  var node = document.createElement("div");
  node.innerHTML = text;
  var content = node.textContent;
  return content.length > length ? content.slice(0, length) + clamp : content;
};

Vue.filter("truncate", filter);

Vue.config.productionTip = false;

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import updateLocale from "dayjs/plugin/updateLocale";
dayjs.extend(relativeTime);
dayjs.extend(updateLocale);
dayjs.updateLocale("en", {
  relativeTime: {
    future: "há %s",
    past: "há %s",
    s: "alguns segundos",
    m: "1 minuto",
    mm: "%d minutos",
    h: "1 hora",
    hh: "%d horas",
    d: "dia",
    dd: "%d dias",
    M: "1 mês",
    MM: "%d meses",
    y: "1 ano",
    yy: "%d anos",
  },
});
Vue.use(dayjs);

store
  .dispatch("auth/attempt", {
    user: JSON.parse(localStorage.getItem("user")),
    token: localStorage.getItem("token"),
  })
  .then(() => {
    new Vue({
      // beforeMount() {
      //   // window.addEventListener("load", this.onLoad);
      //   window.addEventListener("beforeunload", this.onUnload);
      // },
      // beforeDestroy() {
      //   // window.addEventListener("load", this.onLoad);
      //   window.addEventListener("beforeunload", this.onUnload);
      // },
      // methods: {
      //   onUnload() {
      //     if (window.localStorage.getItem("postTypes")) {
      //       window.localStorage.removeItem("postTypes");
      //     }
      //   },
      // },
      router,
      render: (h) => h(App),
      store: store,
    }).$mount("#app");
  });
