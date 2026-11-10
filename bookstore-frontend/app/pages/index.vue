<script setup lang="ts">
const { apiFetch } = useApi()

const { data: booksResponse, pending, error } = await apiFetch<{ data: any[] }>('/books')

const { data: categoriesResponse } = await apiFetch<{ data: any[] }>('/categories')

const books = computed(() => booksResponse.value?.data ?? [])
const categories = computed(() => categoriesResponse.value?.data ?? [])
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section class="bg-indigo-700 text-white rounded-xl p-10 mb-10">
      <h1 class="text-4xl font-bold mb-4">
        Discover Your Next Favorite Book
      </h1>

      <p class="text-indigo-100 mb-6">
        Explore our collection of books and find something inspiring.
      </p>

      <NuxtLink
          to="/books"
          class="inline-block bg-white text-indigo-700 px-6 py-3 rounded-lg font-semibold"
      >
        Browse Books
      </NuxtLink>
    </section>

    <!-- Categories -->
    <section class="mb-10">
      <h2 class="text-2xl font-bold mb-5">Categories</h2>

      <div class="flex flex-wrap gap-3">
        <NuxtLink
            v-for="category in categories"
            :key="category.id"
            :to="`/books?category=${category.slug}`"
            class="bg-gray-100 hover:bg-indigo-100 px-5 py-3 rounded-lg"
        >
          {{ category.name }}
        </NuxtLink>
      </div>
    </section>

    <!-- Featured Books -->
    <section>
      <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-bold">Latest Books</h2>

        <NuxtLink to="/books" class="text-indigo-700">
          View All
        </NuxtLink>
      </div>

      <div v-if="pending" class="py-10 text-center">
        Loading books...
      </div>

      <div v-else-if="error" class="py-10 text-center text-red-600">
        Unable to load books.
      </div>

      <div
          v-else
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
      >
        <BookCard
            v-for="book in books.slice(0, 8)"
            :key="book.id"
            :book="book"
        />
      </div>
    </section>
  </div>
</template>