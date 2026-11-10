export default defineNuxtRouteMiddleware((to) => {
    const { authToken } = useAdminAuth()

    if (!authToken.value && to.path !== '/admin/login') {
        return navigateTo('/admin/login')
    }

    if (authToken.value && to.path === '/admin/login') {
        return navigateTo('/admin')
    }
})