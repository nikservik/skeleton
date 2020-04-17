import VueRouter from 'vue-router'
import VueAuth from '@websanova/vue-auth'
// Pages
import Home from './views/Home'
import Sky from './views/Sky'
import Books from './views/Books'
import Register from './views/auth/Register'
import Login from './views/auth/Login'
import Remind from './views/auth/Remind'
import RemindNewPassword from './views/auth/RemindNewPassword'
import Verify from './views/auth/Verify'
import Dashboard from './views/user/Dashboard'
import Subscription from './views/user/Subscription'

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
  { name: 'dashboard', path: '/dashboard', component: Dashboard, meta: { auth: true } },
  { name: 'subscription', path: '/subscription', component: Subscription, meta: { auth: true } },
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
router.beforeEach((to, from, next) => {
    if ('feature' in to.meta) 
        if (window.Vue.auth.check() && window.Vue.auth.user().features 
          && window.Vue.auth.user().features.includes(to.meta.feature)) 
            next()
        else next('/login')
    else next()
})
export default router