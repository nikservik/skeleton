import axios from 'axios'

export const support = {
  namespaced: true,
  state: {
    unread: undefined,
    messages: undefined,
    pagination: undefined,
  },
  mutations: {
    SET_MESSAGES (state, data) {
      state.messages = data.data
      state.pagination = data
    },
    SET_UNREAD (state, unread) {
      state.unread = unread
    },
  },
  actions: {
    loadUnread (context) {
      if (context.rootGetters['auth/loggedIn'])
        axios
          .get('/support/unread')
          .then(({ data }) => {
            context.commit('SET_UNREAD', data.unread)
          })
    },
    load({ commit }) {
      axios
        .get('/support')
        .then(({ data }) => {
          commit('SET_MESSAGES', data.messages)
          commit('SET_UNREAD', 0)
        })
    },
    send(context, message) {
      axios
        .post('/support', { message: message })
        .then(({ data }) => {
          context.commit('SET_MESSAGES', data.messages)
          context.commit('SET_UNREAD', 0)
        })
        .catch((error) => {
          if (error.response.status != 422)
            context.dispatch('errors/set', { connection: 'failed' }, { root: true })
          else
            context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
  },
  getters: {
  }
};