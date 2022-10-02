import { LocalStorage } from 'quasar'
import { api } from 'src/boot/axios'
import { useAuthStore } from 'src/stores'
import { AuthUser } from 'src/types'
import { readonly, reactive } from 'vue'
import { urlBuilder } from './url-builder'

interface TenantItem {
  id: number
  name: string
  trade_name: string
  logo_url?: string
}
export interface TenantState {
  tenant: null | number
  tenants: TenantItem[]
}

const _state = reactive<TenantState>({
  tenant: null,
  tenants: []
})

const TENANT_STORAGE_KEY = 'tenant'
const TENANT_LOGO_STORAGE_KEY = 'tenant_logo'

let state = readonly(_state)

const changeState = (data: Partial<TenantState>) => {
  Object.assign(_state, { ...data })

  state = readonly(_state)
}

const getUser = (): AuthUser => {
  const store = useAuthStore()
  const user = store.getUser as AuthUser
  return user
}

const loadTenant = (): number | null => {
  const localTenant = LocalStorage.getItem(TENANT_STORAGE_KEY) as number

  let tenant = localTenant ? localTenant : null
  if (!tenant) {
    const user = getUser()

    tenant = user.tenant_id | user.tenant
    if (!tenant) {
      const [company] = state.tenants
      if (company) tenant = company.id
    }
    LocalStorage.set(TENANT_STORAGE_KEY, tenant)
  }
  changeState({ tenant })

  return state.tenant
}

const loadTenants = async () => {
  if (state.tenants.length) return
  const url = urlBuilder('tenants')
  const response = await api.get(url)
  const tenants = response.data as TenantItem[]
  const localTenant = LocalStorage.getItem(TENANT_STORAGE_KEY)
  if (!localTenant || localTenant === 'undefined') {
    const [tenant] = tenants

    LocalStorage.set(TENANT_STORAGE_KEY, tenant.id)
    LocalStorage.set(TENANT_LOGO_STORAGE_KEY, tenant.logo_url ?? null)

    changeState({ tenant: tenant.id })
  }
  changeState({ tenants })
}

export function useTenant() {
  return {
    getTenant() {
      if (!state.tenant) return loadTenant()
      return state.tenant
    },

    async setTenantName() {
      const tenants = await this.getTenants()
      const tenant = this.getTenant()
      const current = tenants.find(({ id }) => id === tenant)
      return current?.name || ''
    },

    async getTenants() {
      if (!state.tenants.length) await loadTenants()

      return [...state.tenants]
    },

    setTenant(tenant: number, logo_url?: string) {
      if (!tenant) return

      LocalStorage.set(TENANT_STORAGE_KEY, tenant)
      LocalStorage.set(TENANT_LOGO_STORAGE_KEY, logo_url ?? null)

      window.location.reload()
    },

    clearTenant() {
      LocalStorage.remove(TENANT_STORAGE_KEY)
    }
  }
}
