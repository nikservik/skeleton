import axios from 'axios'
import i18n  from '@/i18n'

export const locale = {
  namespaced: true,
  state: {
    locale: undefined,
    subscriptionsLoaded: false,
    tariffsLoaded: false,
  },
  mutations: {
    SET_LOCALE (state, locale) {
      state.locale = locale
      i18n.locale = locale
      localStorage.setItem('locale', locale)
    },
    SET_SUBSCRIPTIONS_LOADED (state) {
      state.subscriptionsLoaded = true
    },
    SET_TARIFFS_LOADED (state) {
      state.tariffsLoaded = true
    },
  },
  actions: {
    set (context, locale) {
      context.commit('SET_LOCALE', locale)
      if (context.rootGetters['auth/loggedIn']) 
        axios.post('/locale', { locale: locale })
          .then(() => {console.log('locale set')})
    },
    loadSubscriptions(context) {
      if (! context.state.subscriptionsLoaded) 
        axios
          .get('/subscriptions/translations')
          .then(response => {
            for (let [feature, translations] of Object.entries(response.data.data.features))
              context.dispatch('addToLocale', {
                name: 'features.'+feature,
                translations: translations
              })
            for (let [period, translations] of Object.entries(response.data.data.periods)) {
              for (let locale in translations) {
                translations[locale] = translations[locale].replace('1 ', '')
              }
              context.dispatch('addToLocale', {
                name: 'periods.'+period,
                translations: translations
              })
            }
            context.commit('SET_SUBSCRIPTIONS_LOADED')
          })
    },
    loadTariffs(context) {
      if (! context.state.tariffsLoaded) 
        axios
          .get('/subscriptions')
          .then(response => {
            response.data.data.subscriptions.forEach((tariff) => {
              context.dispatch('addToLocale', {
                name: 'tariffs.'+tariff.slug,
                translations: tariff.name
              })
            })
            context.commit('SET_TARIFFS_LOADED')
          })
    },
    addToLocale(context, pack) {
      for (let locale in pack.translations)
        i18n.mergeLocaleMessage(locale, {[pack.name]: pack.translations[locale]})
    }
  },
  getters: {
  }
};