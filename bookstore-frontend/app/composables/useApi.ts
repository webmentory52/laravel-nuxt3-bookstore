
export const useApi = () => {
    const config = useRuntimeConfig()

    const apiFetch = <T>(endpoint: string, options?: Record<string, any>) => {
        return useFetch<T>(`${config.public.apiBase}${endpoint}`, options as any)
    }

    return {
        apiFetch
    }
}