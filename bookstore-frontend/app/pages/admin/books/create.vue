<script setup lang="ts">
import BookForm from "~/components/admin/BookForm.vue";

definePageMeta({
  layout: 'admin',
  middleware: 'admin',
})

const { request } = useAdminApi()

const { data: categories } = await useAsyncData(
    'admin-book-categories',
    () => request<any[]>('categories')
)

const save = async (form: FormData) => {
  await request('books', {
    method: 'POST',
    body: form,
  })

  await navigateTo('/admin/books')
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Add Book</h1>
    <BookForm :categories="categories || []" @submit="save" />
  </div>
</template>