import Vue from 'vue'
import Router from 'vue-router'
import store from './store/index'
// Pages
import Home from './views/Home'
import Sky from './views/Sky'
import Books from './views/Books'
import Register from './views/auth/Register'
import Login from './views/auth/Login'
import Remind from './views/auth/Remind'
import RemindNewPassword from './views/auth/RemindNewPassword'
import Verify from './views/auth/Verify'
import Profile from './views/user/Profile'
import Subscription from './views/user/Subscription'
import ChangeSubscription from './views/user/ChangeSubscription'

// Routes
const routes = [
  { name: 'home', path: '/', component: Home, meta: { auth: undefined } },
  { name: 'sky', path: '/sky', component: Sky, meta: { auth: true, feature: 'see-sky' } },
  { name: 'books', path: '/books', component: Books, meta: { auth: true, feature: 'read-books' } },
  { name: 'register', path: '/register', component: Register, meta: { auth: false } },
  { name: 'login', path: '/login', component: Login, meta: { auth: false } },
  { name: 'remind', path: '/remind', component: Remind, meta: { auth: undefined }, },
  { name: 'remind-new', path: '/remind/new', component: RemindNewPassword, meta: { auth: undefined }, },
  { name: 'verify', path: '/verify', component: Verify, meta: { auth: true }, },
  { name: 'profile', path: '/profile', component: Profile, meta: { auth: true } },
  { name: 'subscription', path: '/subscription', component: Subscription, meta: { auth: true } },
  { name: 'subscription-change', path: '/subscription/change', component: ChangeSubscription, meta: { auth: true } },
]

Vue.use(Router)

const router = new Router({
  history: true,
  mode: 'history',
  routes,
})
router.beforeEach((to, from, next) => {
  if (store.getters['auth/canSee'](to.meta)) 
    if (store.getters['auth/needVerification'])
      next('/verify')
    else
      next()
  else
    next(false)
})
export default router