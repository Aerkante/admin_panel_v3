import { User } from 'src/models'
export interface Company {
  id: number | undefined
  responsable_name: string
  trade_name: string
  user: User
  cpf_cnpj: string
  logo: string
  logo_url: string
  phone: string
  status: number
  image_id: number
  instagram: string
}
