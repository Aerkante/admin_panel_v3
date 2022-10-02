export function removeDataFromStore<T> (data: T): T {
  let parsedData = {} as T

  Object.keys(data).forEach(key => {
    const value = (data as Record<string, unknown>)[key]

    parsedData = {
      ...parsedData,
      [key]: typeof value === 'object' ? { ...value } : value
    }
  })

  return parsedData
}
