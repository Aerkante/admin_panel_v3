import { ViaCepResponse } from 'src/types'

const BASE_URL = 'https://viacep.com.br/ws/ZIP/json'

export function useViaCep () {
  return {
    async getAddress (zip: string): Promise<ViaCepResponse> {
      return fetch(BASE_URL.replace('ZIP', zip), {
        method: 'GET',
        mode: 'cors',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json'
        }
      }).then(response => (response.json() as unknown) as ViaCepResponse)
    }
  }
}
