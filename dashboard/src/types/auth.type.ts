import { Company } from 'src/models'

export const roles = ['admin', 'company'] as const

export type Role = typeof roles[number]

export type AuthUser = {
  id: number
  name: string
  email: string
  avatar?: string
  roles: Role[]
  avatar_url?: string
  logo?: string
  logo_url?: string
  company: Company
  tenant_id: number
  tenant: number
}

export type AuthToken = {
  type: string
  token: string
}

export type AuthLoginForm = {
  email: string
  password: string
}

export type LocalStorage = {
  token: AuthToken
  user: AuthUser
  tenant?: number
}
