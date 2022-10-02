import { Role } from '.'

export type RouteMeta = {
  name: string
  requireAuth: boolean
  canSeeRoute: Role[]
}
