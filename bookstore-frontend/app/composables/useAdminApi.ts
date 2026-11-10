export const useAdminApi = () => {
    const config = useRuntimeConfig()
    const { authToken } = useAdminAuth()

    const request = <T>(url: string, options: any = {}) => {
        return $fetch<T>(`${config.public.apiBase}/admin/${url}`, {
            ...options,
            headers: {
                ...options.headers,
                Authorization: `Bearer ${authToken.value}`,
                Accept: 'application/json',
            },
        })
    }

    return { request }
}