import { Pagination, PaginationResponse } from 'src/types'

export function paginationParser (
  data: Omit<PaginationResponse, 'data'>
): Partial<Pagination> {
  return {
    page: data.current_page,
    rowsPerPage: data.per_page,
    rowsNumber: data.total
  }
}
