import { RouteRecordRaw } from 'vue-router'
import authRoutes from './auth'

const routes: RouteRecordRaw[] = [
  ...authRoutes,
  {
    path: '/:catchAll(.*)*',
    component: () => import('src/pages/error/Error404.vue'),
    meta: { name: 'Página Não Encontrada' }
  }
]

export default routes
