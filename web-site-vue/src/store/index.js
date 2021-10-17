import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    postTypes: [],
  },

  getters: {
    getPostTypes(state) {
      return state.postTypes;
    },
  },

  mutations: {
    SET_POSTTYPES(state, postTypes) {
      state.postTypes = postTypes;
    },
  },

  actions: {
    storePostTypes({ dispatch }, postTypes) {
      dispatch("savePostTypes", postTypes);
    },
    async savePostTypes({ commit }, data) {
      if (data) {
        commit("SET_POSTTYPES", data);
      }
    },
  },

  modules: {
    auth,
  },
});
