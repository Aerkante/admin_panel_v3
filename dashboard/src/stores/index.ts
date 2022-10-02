import { store } from 'quasar/wrappers'
import { createPinia } from 'pinia'

export * from './auth'

export default store((/* { ssrContext } */) => {
  const pinia = createPinia()

  // You can add Pinia plugins here
  // pinia.use(SomePiniaPlugin)

  return pinia
})
