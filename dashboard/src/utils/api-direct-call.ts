export function apiDirectCall (uri: string) {
  const baseUrl = process.env.VUE_API_URL as string
  return `${baseUrl}/${uri}`
}
