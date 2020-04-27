import axios from 'axios'

export const auth = {
  namespaced: true,
  state: {
    token: undefined,
    user: undefined,
  },
  mutations: {
    SET_TOKEN (state, token) {
      state.token = token
      localStorage.setItem('token', token)
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    },
    SET_USER_DATA (state, user) {
      state.user = user
    },
    UPDATE_USER_DATA (state, data) {
      for (var key in data) 
        state.user[key] = data[key]
    },
    CLEAR_USER_DATA (state) {
      state.user = undefined
      state.token = undefined
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  },
  actions: {
    register ({ commit }, credentials) {
      return axios
        .post('auth/register', credentials)
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    login (context, credentials) {
      return axios
        .post('auth/login', credentials)
        .then((response) => {
          context.dispatch('setToken', response.data.token)
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    logout ({ commit }) {
      commit('CLEAR_USER_DATA')
    },
    setToken (context, token) {
      context.commit('SET_TOKEN', token)
      context.dispatch('fetch')
    },
    fetch (context) {
      return axios
        .get('auth/user')
        .then(({ data }) => {
          context.commit('SET_USER_DATA', data.data)
          context.dispatch('locale/set', data.data.locale, { root: true })
        })
    },
    saveName(context, name) {
      return axios
        .post('/user/name', { name: name })
        .then(({ data }) => {
          context.commit('UPDATE_USER_DATA', { name: name })
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    saveEmail(context, email) {
      return axios
        .post('/user/email', { email: email })
        .then(({ data }) => {
          context.commit('UPDATE_USER_DATA', { email: email })
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    savePassword(context, passwords) {
      return axios
        .post('/user/password', passwords)
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
  },
  getters: {
    loggedIn (state) {
      return !!state.token
    },
    features (state) {
      return (!!state.user) ? state.user.features : []
    },
    canSee: (state, getters) => (meta) => {
      if (meta.auth === undefined)
        return true
      if (meta.auth === false && ! getters.loggedIn)
        return true
      if (meta.auth && getters.loggedIn) {
        if (! meta.feature)
          return true
        if (meta.feature in getters.features)
          return true
      }
      return false
    },
    needVerification (state, getters) {
      return getters.loggedIn && ! state.user.email_verified_at
    },
  }
};