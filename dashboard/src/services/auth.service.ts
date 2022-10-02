import { AuthLoginForm, AuthToken, AuthUser } from 'src/types'
import { api } from 'src/boot/axios'
import { isValidLoginToken } from 'src/utils'
import { TOKEN_STORAGE_KEY, USER_STORAGE_KEY } from 'src/stores'
import { LocalStorage } from 'quasar'

type ResponseAuthToken = {
  access_token: string
  token_type: string
}

export class AuthService {
  async login(credentials: AuthLoginForm) {
    const url = 'auth/login/panel'

    const response = await api.post<ResponseAuthToken>(url, credentials)
    const data = response.data
    this.setAuth({ token: data.access_token, type: data.token_type })
    return response
  }

  setAuth(token: AuthToken) {
    const headers = (api.defaults.headers || {}) as Record<string, unknown>

    api.defaults.headers = {
      ...headers,
      Authorization: `${token.type} ${token.token}`
    }
  }

  async getUserInfo(): Promise<AuthUser> {
    const url = 'auth/me'
    try {
      const response = await api.post<AuthUser>(url)
      return response.data
    } catch (error) {
      this.clearAuth()
      return {} as AuthUser
    }
  }

  async logout() {
    try {
      const url = 'auth/logout'
      void api.post(url)
    } catch (error) {
    } finally {
      this.clearAuth()
    }
  }

  async loadAuth() {
    const localToken = LocalStorage.getItem(TOKEN_STORAGE_KEY) as AuthToken
    const localUser = LocalStorage.getItem(USER_STORAGE_KEY)

    if (!isValidLoginToken(localToken)) {
      await this.clearAuth()

      return false
    }

    await this.setAuth(localToken)
    let user: AuthUser
    const token = localToken

    if (localUser) {
      user = localUser as AuthUser
    } else {
      user = await this.getUserInfo()
    }

    return { user, token }
  }

  clearAuth() {
    return {}
  }
}
