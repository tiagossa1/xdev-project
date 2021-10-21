import Vue from "vue";
import VueRouter from "vue-router";

import Home from "../views/Home.vue";
import Register from "../views/Register.vue";
import Login from "../views/Login.vue";
import Profile from "../views/Profile.vue";
import Moderation from "../views/Moderation.vue";
import Verification from '../views/Verification.vue';

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
    path: "/moderation",
    name: "Moderation",
    component: Moderation,
  },
  {
    path: '/verification',
    name: "Verification",
    component: Verification
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
  const user = store.getters["auth/user"];
  const isAuthenticated = store.getters["auth/authenticated"];
  const moderatorIds = [2, 4];
  let isModerator = false;

  if (user) {
    isModerator = moderatorIds.includes(user.user_type.id);
  }

  if (to.name === "Moderation" && !isModerator) {
    next({ name: "Home" });
  }

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
