import { route } from 'quasar/wrappers'
import { useAuthStore } from 'src/stores'
import { RouteMeta } from 'src/types'
import { getFirstPage } from 'src/utils/get-first-page'
import {
  createMemoryHistory,
  createRouter,
  createWebHashHistory,
  createWebHistory
} from 'vue-router'

import routes from './routes'

export default route(function (
  {
    /*store*/
  }
) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === 'history'
    ? createWebHistory
    : createWebHashHistory

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,
    history: createHistory(process.env.VUE_ROUTER_BASE)
  })

  Router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()

    let isLogged = authStore.isLogged

    if (!isLogged) await authStore.loadAuth()

    isLogged = authStore.isLogged

    const userRoles = authStore.roles

    const baseRoute = getFirstPage(userRoles)

    const meta = to.meta as RouteMeta
    const requiredAuth = meta.requireAuth
    const routeName = to.name as string

    const authRoutes = ['auth.login', 'auth.forgot']

    if (requiredAuth && !isLogged) {
      if (baseRoute === '/auth/login') {
        await authStore.logout()
      }
      return next({ name: 'auth.login', query: { redirect: to.path } })
    }
    if (authRoutes.includes(routeName) && isLogged) return next(baseRoute)

    return next()
  })

  return Router
})
