import { EmailValidator } from 'src/utils'

export const LoginValidator = {
  email: [(val: string) => EmailValidator(val) || 'Insira um e-mail válido.'],
  password: [(val: string) => !!val || 'Campo obrigatório.']
} as Record<string, unknown>
