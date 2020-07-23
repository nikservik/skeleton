export const nightmode = {
  namespaced: true,
  state: {
    mode: '',
  },
  mutations: {
    SET_MODE (state, mode) {
      localStorage.setItem('nightmode', mode)
      state.mode = mode
      if (mode == 'on') 
        document.documentElement.classList.add('mode-dark');
      else
        document.documentElement.classList.remove('mode-dark');
    },
  },
  actions: {
    set ({ commit }, mode) {
      commit('SET_MODE', mode)
    },
  },
};