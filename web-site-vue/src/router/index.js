import Vue from "vue";
import VueRouter from "vue-router";

import Home from "../views/Home.vue";
import Register from "../views/Register.vue";
import Login from "../views/Login.vue";
import Profile from "../views/Profile.vue";
import store from "@/store";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/profile/:id?",
    name: "Profile",
    component: Profile,
  },
  {
    path: "*",
    redirect: "/",
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, __, next) => {
  const isAuthenticated = store.getters["auth/authenticated"];

  if (isAuthenticated) {
    if (to.name === "Login" || to.name === "Register") {
      next({ name: "Home" });
    }
  } else {
    if (to.name === "Home") {
      next({ name: "Login" });
    }
  }

  next();
});

export default router;
