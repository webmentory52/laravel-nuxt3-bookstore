<script setup lang="ts">
import BookForm from "~/components/admin/BookForm.vue";

definePageMeta({
  layout: 'admin',
  middleware: 'admin',
})

const route = useRoute()
const { request } = useAdminApi()

const { data: books } = await useAsyncData(
    'admin-books-for-edit',
    () => request<any>('books')
)

const book = computed(() =>
    books.value?.data?.find((item: any) => item.id === Number(route.params.id))
)

const { data: categories } = await useAsyncData(
    'admin-edit-categories',
    () => request<any[]>('categories')
)

const save = async (form: FormData) => {
  // Laravel handles multipart POST uploads more reliably than PUT/PATCH.
  form.append('_method', 'PUT')

  await request(`books/${route.params.id}`, {
    method: 'POST',
    body: form,
  })

  await navigateTo('/admin/books')
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Edit Book</h1>

    <BookForm
        v-if="book"
        :book="book"
        :categories="categories || []"
        @submit="save"
    />
  </div>
</template>