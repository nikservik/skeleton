import axios from 'axios'

export const auth = {
  namespaced: true,
  state: {
    token: undefined,
    user: undefined,
    loaded: false,
  },
  mutations: {
    SET_TOKEN (state, token) {
      state.token = token
      localStorage.setItem('token', token)
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    },
    SET_LOADED_STATE (state, loaded) {
      state.loaded = loaded
    },
    SET_USER_DATA (state, user) {
      state.user = user
      state.loaded = true
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
    },
  },
  actions: {
    init (context) {
      var token = localStorage.getItem('token')
      if (token) 
        context.commit('SET_TOKEN', token)
      else
        context.commit('SET_LOADED_STATE', true)
    },
    register (context, credentials) {
      return axios
        .post('auth/register', credentials)
        .catch((error) => {
          if (error.response.status != 422)
            context.dispatch('errors/set', { connection: 'failed' }, { root: true })
          else
            context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    login (context, credentials) {
      return axios
        .post('auth/login', credentials)
        .then(({ data }) => {
          context.commit('SET_TOKEN', data.token)
          context.commit('SET_USER_DATA', data.user)
          if (data.user.locale)
            context.dispatch('locale/set', data.user.locale, { root: true })
        })
        .catch((error) => {
          context.dispatch('errors/set', { login: 'failed' }, { root: true })
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
          if (data.data.locale)
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
    remind(context, email) {
      return axios
        .post('/auth/remind', { email: email })
        .then(({ data }) => {
          context.dispatch('message/show', data.message, { root: true })
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    checkToken(context, credentials) {
      return axios
        .post('/auth/checkToken', credentials)
        .then(({ data }) => {
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    newPassword(context, credentials) {
      return axios
        .post('/auth/newPassword', credentials)
        .then(({ data }) => {
          context.dispatch('message/show', data.message, { root: true })
        })
        .catch((error) => {
          context.dispatch('errors/set', error.response.data.errors, { root: true })
        })
    },
    resendVerification(context) {
      return axios
        .get('/email/resend')
        .then(({ data }) => {
          context.dispatch('message/show', 'messages.newLinkSent', { root: true })
        })
        .catch((error) => {
          context.dispatch('errors/set', { connection: 'failed' }, { root: true })
        })
    },
    verifyEmail(context, credentials) {
      return axios
        .post('/email/verify', credentials)
        .then(({ data }) => {
          context.dispatch('message/show', data.message, { root: true })
        })
        .catch((error) => {
          if (error.response.status == 422)
            context.dispatch('errors/set', { verify: 'failed' }, { root: true })
          else
            context.dispatch('errors/set', { verification: 'failed' }, { root: true })
        })
    },
  },
  getters: {
    loggedIn (state) {
      return !!state.user
    },
    loaded (state) {
      return state.loaded
    },
    features (state) {
      return (!!state.user) ? state.user.features : []
    },
    canUse: (state) => (feature) => {
      return !!state.user && state.user.features && state.user.features.includes(feature)
    },
    canSee: (state, getters) => (meta) => {
      if (meta.auth === undefined)
        return true
      if (meta.auth === false && ! getters.loggedIn)
        return true
      if (meta.auth && getters.loggedIn) {
        if (! meta.feature)
          return true
        if (getters.features.includes(meta.feature))
          return true
      }
      return false
    },
    needVerification (state, getters) {
      return getters.loggedIn && ! state.user.email_verified_at
    },
  }
};