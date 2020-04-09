import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import LoadScript from 'vue-plugin-load-script'
import VueCookie from 'vue-cookie'
import VueI18n from 'vue-i18n'
import Index from './Index'
import auth from './auth'
import router from './router'

window.Vue = Vue

Vue.router = router
Vue.use(VueRouter)

Vue.use(VueAxios, axios)
axios.defaults.baseURL = document.location.origin + '/api'
axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.use(VueAuth, auth)
Vue.use(LoadScript)
Vue.use(VueCookie)

Vue.use(VueI18n)
const i18n = new VueI18n()

Vue.component('index', Index)

const app = new Vue({
  el: '#app',
  router,
  i18n
});