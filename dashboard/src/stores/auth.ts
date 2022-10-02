import { AuthLoginForm, AuthToken, AuthUser, Role } from 'src/types'
import { AxiosResponse } from 'axios'
import { defineStore } from 'pinia'
import { AuthService } from 'src/services'
import { api } from 'src/boot/axios'
import { LocalStorage } from 'quasar'
import { Company } from 'src/models'

const authService = new AuthService()

export const TOKEN_STORAGE_KEY = 'token'
export const COMPANY_STORAGE_KEY = 'company'
export const TENANT_STORAGE_KEY = 'tenant'
export const USER_STORAGE_KEY = 'user'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: {} as AuthUser,
    token: {} as AuthToken
  }),

  getters: {
    isLogged (): boolean {
      return !!this.user.id && !!this.token.token
    },

    getUser (): AuthUser {
      return this.user
    },
    getCompany (): Company {
      return this.user.company
    },

    roles (): Role[] {
      return this.user.roles ?? []
    },

    isAdmin (): boolean {
      return this.user?.roles.includes('admin')
    },
    iscompany (): boolean {
      return this.user?.roles.includes('company')
    }
  },

  actions: {
    async login (data: AuthLoginForm): Promise<number> {
      try {
        const result = await authService.login(data)
        const payload = result.data
        const token = { token: payload.access_token, type: payload.token_type }

        this.token = token
        LocalStorage.set(TOKEN_STORAGE_KEY, this.token)
        await this.getUserInfo()

        return result.status
      } catch (error) {
        return (error as AxiosResponse).status
      }
    },

    async logout () {
      await authService.logout()
      this.clearAuth()
    },

    async getUserInfo (): Promise<void> {
      if (!this.token) return
      if (this.user && this.user.id) return
      this.user = await authService.getUserInfo()
      if (!this.user.id) this.clearAuth()
    },

    async loadAuth () {
      const data = await authService.loadAuth()

      if (data === false) return this.clearAuth()

      this.user = data.user
      this.token = data.token
    },

    clearAuth () {
      LocalStorage.remove(TOKEN_STORAGE_KEY)
      LocalStorage.remove(COMPANY_STORAGE_KEY)
      LocalStorage.remove(TENANT_STORAGE_KEY)
      api.defaults.headers = authService.clearAuth()
      this.token = authService.clearAuth() as AuthToken
      this.user = {} as AuthUser
    }
  }
})
