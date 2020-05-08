import Vue from 'vue'
import Router from 'vue-router'
import store from './store/index'
// Pages
import Home from './views/Home'
import Sky from './views/Sky'
import Books from './views/Books'

import Register from './views/auth/Register'
import Login from './views/auth/Login'
import Settings from './views/Settings'
import Dashboard from './views/user/Dashboard'

// Routes
const routes = [
  { name: 'home', path: '/', component: Home, meta: { auth: undefined } },
  { name: 'sky', path: '/sky', component: Sky, meta: { auth: true, feature: 'see-sky' } },
  { name: 'books', path: '/books', component: Books, meta: { auth: true, feature: 'read-books' } },
  { name: 'register', path: '/register', component: Register, meta: { auth: false } },
  { name: 'login', path: '/login', component: Login, meta: { auth: false } },
  { name: 'dashboard', path: '/dashboard', component: Dashboard, meta: { auth: true } },
  { name: 'settings', path: '/settings', component: Settings, meta: { auth: false } },

  { name: 'oferta', path: '/oferta', component: () => import('@/views/Oferta'), meta: { auth: undefined } },
  { name: 'remind', path: '/remind', component: () => import('@/views/auth/Remind'), meta: { auth: undefined }, },
  { name: 'remind-new', path: '/remind/new', component: () => import('@/views/auth/RemindNewPassword'), meta: { auth: undefined }, },
  { name: 'verify-link', path: '/verify/:user/:hash', component: () => import('@/views/auth/Verify'), meta: { auth: undefined }, },
  { name: 'verify', path: '/verify', component: () => import('@/views/auth/Verify'), meta: { auth: true }, },

  { name: 'profile', path: '/profile', component: () => import('@/views/user/Profile'), meta: { auth: true } },
  { name: 'support', path: '/support', component: () => import('@/views/user/Support'), meta: { auth: true } },
  { name: 'payments', path: '/subscription/payments', component: () => import('@/views/user/PaymentsHistory'), meta: { auth: true } },
  { name: 'payment-card', path: '/subscription/payment-card', component: () => import('@/views/user/PaymentCard'), meta: { auth: true } },
  { name: 'select-tariff', path: '/subscription/select', component: () => import('@/views/user/TariffSelect'), meta: { auth: true } },
]

Vue.use(Router)

const router = new Router({
  history: true,
  mode: 'history',
  routes,
})
router.beforeEach((to, from, next) => {
  var checker = (to, from, next) => {
    if (store.getters['auth/canSee'](to.meta)) 
      if (store.getters['auth/needVerification'] 
          && to.name != 'verify' && to.name != 'verify-link')
        next('/verify')
      else
        next()
    else
      if (to.meta.auth)
        next('/login')
      else
        next('/dashboard')
  }

  if (store.getters['auth/loaded']) 
    checker(to, from, next)
  else
    store.dispatch('auth/init')
      .then(() => {
        if (! store.getters['auth/loaded'])
          store.dispatch('auth/fetch')
            .then(() => { checker(to, from, next) })
        else
          checker(to, from, next)
      })
})
export default router