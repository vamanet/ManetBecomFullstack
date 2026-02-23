import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
import Dashboard from '@/components/Dashboard.vue';
import Users from '@/Pages/Users.vue';
import DashboardFood from '@/Pages/DashboardFood.vue';
import { useAuthStore } from '@/stores/auth';

const routes = [
  { path: '/login', component: Login, meta: { guest: true } },
  { path: '/register', component: Register, meta: { guest: true } },
  { path: '/users', component: Users, meta: { requiresAuth: true } },
  {path: '/dashboardfood', component: DashboardFood, meta: { requiresAuth: true } },
  { path: '/', component: DashboardFood, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  const isLoggedIn = auth.isLoggedIn;

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login');
  } else if (to.meta.guest && isLoggedIn) {
    next('/');
  } else {
    next();
  }
});

export default router;