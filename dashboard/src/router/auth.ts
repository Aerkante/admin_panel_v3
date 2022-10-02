import { RouteRecordRaw } from 'vue-router'

const authRoutes: RouteRecordRaw[] = [
  {
    path: '/auth',
    redirect: '/auth/login',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: 'login',
        name: 'auth.login',
        component: () => import('pages/auth/login.vue'),
        meta: {
          name: 'Login',
          requireAuth: false
        }
      }
    ]
  }
]

export default authRoutes
