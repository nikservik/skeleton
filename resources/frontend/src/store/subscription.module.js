import axios from 'axios'

export const subscription = {
  namespaced: true,
  state: {
    payments: undefined,
    tariffs: undefined,
    features: undefined,
    for3ds: undefined,
  },
  mutations: {
    SET_PAYMENTS (state, payments) {
      state.payments = payments
    },
    SET_TARIFFS (state, tariffs) {
      state.tariffs = tariffs
    },
    SET_FEATURES (state, features) {
      state.features = features
    },
    SET_3DS (state, data) {
      state.for3ds = data
    },
    CLEAR_3DS (state) {
      state.for3ds = undefined
    },
  },
  actions: {
    loadPayments (context) {
      return axios
        .get('/subscriptions/payments')
        .then(({ data }) => {
          context.commit('SET_PAYMENTS', data.data.payments)
        })
    },
    loadTariffs (context) {
      if (! context.state.tariffs) 
        axios
          .get('/subscriptions')
          .then(response => {
            context.commit('SET_TARIFFS', response.data.data.subscriptions)
          })
    },
    loadFeatures (context) {
      if (! context.state.features) 
        axios
          .get('/subscriptions/translations')
          .then(response => {
            context.commit('SET_FEATURES', Object.keys(response.data.data.features))
          })
    },
    activateTariff(context, tariff) {
      return axios
        .post('/subscriptions', { tariff: tariff })
        .then(() => {
          context.dispatch('auth/fetch', {}, { root: true })
        })
        .catch(() => {
          context.dispatch('errors/set', { response: 'errors.failed' }, { root: true })
        })
    },
    cancel(context) {
      return axios
        .post('/subscriptions/cancel')
        .then(() => {
          context.dispatch('auth/fetch', {}, { root: true })
        })
        .catch(() => {
          context.dispatch('errors/set', { response: 'errors.failed' }, { root: true })
        })
    },
    payByCrypt(context, payData) {
      context.commit('CLEAR_3DS')
      return axios
        .post('/subscriptions/crypt', payData)
        .then(({ data }) => {
          if (data.status == 'error') 
            context.dispatch('errors/set', { payment: data.message }, { root: true })
          if (data.status == 'need3ds') 
            context.commit('SET_3DS', data.data)
          if (data.status == 'success') 
            context.dispatch('auth/fetch', {}, { root: true })
        })
        .catch(() => {
          context.dispatch('errors/set', { response: 'errors.failed' }, { root: true })
        })
    },
    authorizeCard(context, payData) {
      context.commit('CLEAR_3DS')
      return axios
        .post('/subscriptions/authorize', payData)
        .then(({ data }) => {
          if (data.status == 'error') 
            context.dispatch('errors/set', { payment: data.message }, { root: true })
          if (data.status == 'need3ds') 
            context.commit('SET_3DS', data.data)
          if (data.status == 'success') 
            context.dispatch('auth/fetch', {}, { root: true })
        })
        .catch(() => {
          context.dispatch('errors/set', { response: 'errors.failed' }, { root: true })
        })
    },
  },
};