import VueRouter from 'vue-router'
// Pages
import Home from './views/Home'
import Register from './views/auth/Register'
import Login from './views/auth/Login'
import Remind from './views/auth/Remind'
import RemindNewPassword from './views/auth/RemindNewPassword'
import Verify from './views/auth/Verify'
import Dashboard from './views/user/Dashboard'

// Routes
const routes = [
  {
    name: 'home',
    path: '/', component: Home, meta: { auth: undefined }
  },
  {
    name: 'register',
    path: '/register', component: Register, meta: { auth: false }
  },
  {
    name: 'login',
    path: '/login', component: Login, meta: { auth: false }
  },
  {
    name: 'remind',
    path: '/remind', component: Remind, meta: { auth: undefined },
  },
  {
    name: 'remind-new',
    path: '/remind/new', component: RemindNewPassword, meta: { auth: undefined },
  },
  {
    name: 'verify',
    path: '/verify', component: Verify, meta: { auth: true },
  },
  // USER ROUTES
  {
    name: 'dashboard',
    path: '/dashboard', component: Dashboard, meta: { auth: true }
  },
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
export default router