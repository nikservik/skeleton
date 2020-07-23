export const loading = {
  namespaced: true,
  state: {
    mode: false,
  },
  mutations: {
    SET_MODE (state, mode) {
      state.mode = mode
    },
  },
  actions: {
    set ({ commit }, mode) {
      commit('SET_MODE', mode) 
    },
  },
  getters: {
    disable (state) {
      return state.mode
    },
  },
};