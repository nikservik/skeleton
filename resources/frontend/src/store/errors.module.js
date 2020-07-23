export const errors = {
  namespaced: true,
  state: {
    errors: {},
  },
  mutations: {
    SET_ERRORS (state, errors) {
      state.errors = errors
    },
    CLEAR_ERRORS (state) {
      state.errors = {}
    },
  },
  actions: {
    set ({ commit }, errors) {
      commit('SET_ERRORS', errors)
    },  
    clear ({ commit }) {
      commit('CLEAR_ERRORS')
    },
  },
  getters: {
    happened (state) {
      return Object.keys(state.errors).length > 0
    },
    list (state) {
      return state.errors
    },
    get: (state) => (key) => {
      return key in state.errors ? state.errors[key] : ''
    },
    getFirst: (state) => (key) => {
      if (! state.errors[key])
        return ''
      if (typeof state.errors[key] == 'object')
        return state.errors[key][0]
      else
        return state.errors[key]
    },
    has: (state) => (key) => {
      return key in state.errors
    },
  }
};