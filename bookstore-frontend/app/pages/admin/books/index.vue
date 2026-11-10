<script setup lang="ts">
  definePageMeta({
    layout: 'admin',
    middleware: 'admin',
  })

  const { request } = useAdminApi()

  const { data: books, refresh } = await useAsyncData(
      'admin-books',
      () => request<any>('books')
  )

  const deleteBook = async (id: number) => {
    if (!confirm('Delete this book?')) return

    await request(`books/${id}`, { method: 'DELETE' })
    await refresh()
  }
</script>

<template>
  <div>
    <div class="flex justify-between mb-6">
      <h1 class="text-2xl font-bold">Books</h1>
      <NuxtLink to="/admin/books/create" class="bg-black text-white px-4 py-2 rounded">
        Add Book
      </NuxtLink>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full text-left">
        <thead>
        <tr class="border-b">
          <th class="p-3">Title</th>
          <th class="p-3">Author</th>
          <th class="p-3">Price</th>
          <th class="p-3">Stock</th>
          <th class="p-3">Actions</th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="book in books?.data" :key="book.id" class="border-b">
            <td class="p-3">{{ book.title }}</td>
            <td class="p-3">{{ book.author }}</td>
            <td class="p-3">{{ book.price }}</td>
            <td class="p-3">{{ book.stock }}</td>
            <td class="p-3 space-x-3">
              <NuxtLink :to="`/admin/books/${book.id}`">Edit</NuxtLink>
              <button @click="deleteBook(book.id)" class="text-red-600">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>