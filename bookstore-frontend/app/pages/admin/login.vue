<script setup lang="ts">
const config = useRuntimeConfig()
const { login } = useAdminAuth()

const form = reactive({
  email: '',
  password: '',
})

const error = ref('')

const submit = async () => {
  error.value = ''

  try {
    const response = await $fetch<any>(
        `${config.public.apiBase}/admin/login`,
        {
          method: 'POST',
          body: form,
        }
    )

    login(response.token)

    await navigateTo('/admin')
  } catch (e: any) {
    error.value = e.data?.message || 'Login failed'
  }
}
</script>

<template>
  <div class="max-w-md mx-auto mt-20 p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-6">Admin Login</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <input
          v-model="form.email"
          type="email"
          placeholder="Email"
          required
          class="w-full border p-3 rounded"
      />

      <input
          v-model="form.password"
          type="password"
          placeholder="Password"
          required
          class="w-full border p-3 rounded"
      />

      <p v-if="error" class="text-red-600">{{ error }}</p>

      <button class="w-full bg-black text-white p-3 rounded">
        Login
      </button>
    </form>
  </div>
</template>