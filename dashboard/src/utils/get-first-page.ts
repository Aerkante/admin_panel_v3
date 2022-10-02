import { Role } from 'src/types'

export const getFirstPage = (roles: Role[]) => {
  if (roles.includes('admin')) return '/indicadores'
  if (roles.includes('admin')) return '/indicadores'
  return '/auth/login'
}
