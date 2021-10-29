import router from "../router";
import userService from "../services/userService";
import Vue from 'vue';

export default {
  namespaced: true,

  state: {
    token: null,
    user: null,
    expiration_date: null,
  },

  getters: {
    authenticated(state) {
      let currentDate = new Date();
      let expiration_date = new Date(state.expiration_date);

      if (expiration_date) {
        if (currentDate < expiration_date && state.user && state.token) {
          return true;
        } else {
          return false;
        }
      }

      return false;
    },
    user(state) {
      return state.user;
    },
  },

  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
    },
    SET_USER(state, user) {
      state.user = user;
    },
    SET_EXPIRATION_DATE(state, expDate) {
      state.expiration_date = expDate;
    },
  },

  actions: {
    signIn({ dispatch }, credentials) {
      userService
        .login(credentials)
        .then((res) => {
          dispatch("attempt", res.data);
          router.push("Home");
        })
        .catch((err) => {
          if (
            err.response.status === 401 &&
            err.response?.data?.type === "UserDidNotVerifiedEmail"
          ) {
            window.localStorage.setItem(
              "loginRequest",
              JSON.stringify(credentials)
            );
            router.push("Verification");
          } else {
            Vue.swal({
              icon: 'error',
              position: 'bottom-right',
              title: err.response.data.message.message,
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000
            })
          }
        });
    },

    async signOut({ commit }) {
      userService.logout().then(() => {
        commit("SET_TOKEN", null);
        commit("SET_USER", null);
        commit("SET_EXPIRATION_DATE", null);

        router.push("Login");
      });
    },

    async attempt({ commit, state }, data) {
      if (data.token) {
        commit("SET_TOKEN", data.token);
      }

      if (data.user) {
        commit("SET_USER", data.user);
      }

      if (!state.token || !state.user) {
        return;
      }

      commit("SET_USER", data.user);
      commit("SET_TOKEN", data.token);

      let expirationDate = new Date();
      expirationDate.setHours(expirationDate.getHours() + 5);

      commit("SET_EXPIRATION_DATE", expirationDate);
    },
  },

  modules: {},
};
