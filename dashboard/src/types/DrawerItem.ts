import { Role } from '.'

export type DrawerItem = {
  name: string
  icon: string
  to?: string
  visibleTo: Role[]
  children?: DrawerItem[]
}
