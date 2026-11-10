const authToken = ref<string | null>(null)

export const useAdminAuth = () => {
    const login = (value: string) => {
        authToken.value = value
    }

    const logout = () => {
        authToken.value = null

        return navigateTo('/admin/login')
    }

    return {
        authToken,
        login,
        logout,
    }
}