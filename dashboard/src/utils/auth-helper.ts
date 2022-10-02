import { AuthToken, Role } from 'src/types'

type UserCanPayload = {
  rolesCan?: Role[]
  userRoles?: Role[]
}

export const isValidLoginToken = (token: AuthToken) => {
  try {
    const currentDate = new Date().getTime()
    const loginData = JSON.parse(atob(token.token.split('.')[1])) as unknown
    const { exp } = loginData as { exp: number }
    return currentDate < exp * 1000
  } catch (error) {
    return false
  }
}

export const userCan = ({ rolesCan, userRoles }: UserCanPayload): boolean => {
  if (!rolesCan?.length || !userRoles?.length) return false

  for (const userRole of userRoles) {
    if (rolesCan.includes(userRole)) return true
  }

  return false
}
