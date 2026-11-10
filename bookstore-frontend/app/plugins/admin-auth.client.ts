export default defineNuxtPlugin(() => {
    const { authToken } = useAdminAuth()

    authToken.value = localStorage.getItem('admin_token')

    watch(authToken, (value) => {
        if (value) {
            localStorage.setItem('admin_token', value)
        } else {
            localStorage.removeItem('admin_token')
        }
    })
})