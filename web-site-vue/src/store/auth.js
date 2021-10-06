import router from "../router";
import userService from "../services/userService";

export default {
  namespaced: true,

  state: {
    token: null,
    user: null,
  },

  getters: {
    authenticated(state) {
      if (state.user && state.token) return true;

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
  },

  actions: {
    signIn({ dispatch }, credentials) {
      userService.login(credentials).then((res) => {
        dispatch("attempt", res.data);
        router.push('Home');
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
    },

    async signOut({ commit }) {
      userService.logout().then(() => {
        commit('SET_TOKEN', null);
        commit('SET_USER', null);

        router.push('Login');
      });
    }
  },

  modules: {},
};
