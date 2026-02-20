import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/Pages/Auth/Login.vue'
import Register from '@/Pages/Auth/Register.vue'
import UserDashboard from '@/Pages/UserDashboard.vue'
import Profile from '@/Pages/Profile.vue'
import Dashboard from './Pages/DashboardOne/Dashboard.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { requiresGuest: true },
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { requiresGuest: true },
  },
  {
    path: '/userdashboard',
    name: 'UserDashboard',
    component: UserDashboard,
    meta: { requiresAuth: true },
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: { requiresAuth: true },
  },
 {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { requiresAuth: true },
  },

  {
    path: '/:pathMatch(.*)*',
    redirect: '/register',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Route guard for authentication
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('auth_token')
  
  if (to.meta.requiresGuest && token) {
    // If already logged in, redirect to dashboard
    next('/userdashboard')
  } else if (to.meta.requiresAuth && !token) {
    // If not logged in, redirect to login
    next('/login')
  } else {
    next()
  }
})

export default router
