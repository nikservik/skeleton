import axios from 'axios'
import Vue from 'vue'
import LoadScript from 'vue-plugin-load-script'

import App from './App'
import router from './router'
import i18n from './i18n'
import store from './store'

import './assets/styles/app.scss'; 

Vue.config.productionTip = false
Vue.use(axios)
Vue.use(LoadScript)

axios.defaults.baseURL = process.env.VUE_APP_API_URL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

new Vue({
  router,
  store,
  i18n,
  created() {
    this.$store.dispatch('locale/set', localStorage.getItem('locale') || 'ru')
    this.$store.dispatch('nightmode/set', localStorage.getItem('nightmode')
      || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'on' : 'off') )
    
    axios.interceptors.response.use(
      response => response,
      error => {
        if (error.response.status === 401) {
          this.$store.dispatch('auth/logout')
        }
        return Promise.reject(error)
      })
    axios.interceptors.request.use(
      config => {
        this.$store.dispatch('loading/set', true)
        return config;
      }, error => {
        return Promise.reject(error);
      })
    axios.interceptors.response.use(
      response => {
        this.$store.dispatch('loading/set', false)
        return response;
      }, error => {
        this.$store.dispatch('loading/set', false)
        return Promise.reject(error);
      })
  },
  render: h => h(App)
}).$mount('#app')
