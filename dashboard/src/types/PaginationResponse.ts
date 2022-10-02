export type PaginationResponse<T = unknown> = {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
}
