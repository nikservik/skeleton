export const message = {
  namespaced: true,
  state: {
    message: '',
  },
  mutations: {
    SET_MESSAGE (state, message) {
      state.message = message
    },
    CLEAR_MESSAGE (state) {
      state.message = ''
    },
  },
  actions: {
    show ({ commit }, message, autoclear=true) {
      commit('SET_MESSAGE', message)
      if (autoclear)
        setTimeout(() => { commit('CLEAR_MESSAGE') }, 10000)
    },
    clear ({ commit }) {
      commit('CLEAR_MESSAGE')
    },
  },
};