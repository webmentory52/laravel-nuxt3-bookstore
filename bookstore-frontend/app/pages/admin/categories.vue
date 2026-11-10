<script setup lang="ts">
definePageMeta({
  layout: 'admin',
  middleware: 'admin',
})

const { request } = useAdminApi()

const name = ref('')
const error = ref('')

const { data: categories, refresh } = await useAsyncData(
    'admin-categories',
    () => request<any[]>('categories')
)

const addCategory = async () => {
  error.value = ''

  try {
    await request('categories', {
      method: 'POST',
      body: { name: name.value },
    })

    name.value = ''
    await refresh()
  } catch (e: any) {
    error.value = e.data?.message || 'Could not add category'
  }
}

const deleteCategory = async (id: number) => {
  if (!confirm('Delete this category?')) return

  try {
    await request(`categories/${id}`, { method: 'DELETE' })
    await refresh()
  } catch (e: any) {
    error.value = e.data?.message || 'Could not delete category'
  }
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Categories</h1>

    <form @submit.prevent="addCategory" class="flex gap-2 mb-6">
      <input v-model="name" required placeholder="Category name" class="border p-3 rounded flex-1" />
      <button class="bg-black text-white px-5 rounded">Add</button>
    </form>

    <p v-if="error" class="text-red-600 mb-4">{{ error }}</p>

    <div class="bg-white rounded shadow divide-y">
      <div
          v-for="category in categories"
          :key="category.id"
          class="p-4 flex justify-between"
      >
        <span>{{ category.name }} ({{ category.books_count }} books)</span>

        <button
            @click="deleteCategory(category.id)"
            class="text-red-600"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>