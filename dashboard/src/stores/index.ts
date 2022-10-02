import { store } from 'quasar/wrappers'
import { createPinia } from 'pinia'

export * from './auth'
export * from './user'
export * from './company'
export * from './category'
export * from './block'
export * from './sale'
export * from './city'
export * from './availableCity'
export * from './client'
export * from './terms'
export * from './policy'
export * from './week'
export * from './province'
export * from './gift-lot'
export * from './gift'
export * from './banner'
export * from './settings'
export * from './order'
export * from './indicator'
export * from './usedSale'

export default store((/* { ssrContext } */) => {
  const pinia = createPinia()

  // You can add Pinia plugins here
  // pinia.use(SomePiniaPlugin)

  return pinia
})
