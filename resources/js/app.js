import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
import LoadScript from 'vue-plugin-load-script'
import VueTheMask from 'vue-the-mask'

import Index from './Index'
import router from './router'
import i18n from './i18n'
import store from './store/index'

window.Vue = Vue

Vue.router = router
Vue.use(Vuex, axios, VueTheMask)
Vue.use(LoadScript)

axios.defaults.baseURL = document.location.origin + '/api'
// axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.component('index', Index)

const app = new Vue({
  el: '#app',
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
  }
});
