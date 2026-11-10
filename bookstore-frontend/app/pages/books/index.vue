<script setup lang="ts">
const route = useRoute()
const router = useRouter()

const { apiFetch } = useApi()

const search = ref(
    typeof route.query.search === 'string'
        ? route.query.search
        : ''
)

const category = ref(
    typeof route.query.category === 'string'
        ? route.query.category
        : ''
)

const page = computed(() => Number(route.query.page) || 1)

const { data: categoriesResponse } = await apiFetch<{ data: any[] }>('/categories')

const categories = computed(() => categoriesResponse.value?.data ?? [])

const { data: booksResponse, pending, error } = await useFetch<{
  data: any[]
  meta: {
    current_page: number
    last_page: number
  }
}>('/books', {
  baseURL: useRuntimeConfig().public.apiBase,
  query: computed(() => ({
    search: route.query.search,
    category: route.query.category,
    page: page.value
  })),
  watch: [() => route.query]
})

const books = computed(() => booksResponse.value?.data ?? [])

const pagination = computed(() => booksResponse.value?.meta)

function applyFilters() {
  router.push({
    path: '/books',
    query: {
      ...(search.value ? { search: search.value } : {}),
      ...(category.value ? { category: category.value } : {})
    }
  })
}

function changePage(nextPage: number) {
  router.push({
    path: '/books',
    query: {
      ...route.query,
      page: nextPage
    }
  })
}
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Our Books</h1>

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
      <input
          v-model="search"
          type="text"
          placeholder="Search books or authors..."
          class="border rounded-lg px-4 py-3 flex-1"
          @keyup.enter="applyFilters"
      />

      <select
          v-model="category"
          class="border rounded-lg px-4 py-3"
      >
        <option value="">All Categories</option>

        <option
            v-for="item in categories"
            :key="item.id"
            :value="item.slug"
        >
          {{ item.name }}
        </option>
      </select>

      <button
          @click="applyFilters"
          class="bg-indigo-700 text-white rounded-lg px-6 py-3"
      >
        Search
      </button>
    </div>

    <!-- Results -->
    <div v-if="pending" class="py-10 text-center">
      Loading books...
    </div>

    <div v-else-if="error" class="py-10 text-center text-red-600">
      Unable to load books.
    </div>

    <template v-else>
      <div
          v-if="books.length"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
      >
        <BookCard
            v-for="book in books"
            :key="book.id"
            :book="book"
        />
      </div>

      <p v-else class="text-center text-gray-500 py-10">
        No books found.
      </p>

      <!-- Pagination -->
      <div
          v-if="pagination && pagination.last_page > 1"
          class="flex justify-center items-center gap-4 mt-10"
      >
        <button
            :disabled="pagination.current_page <= 1"
            @click="changePage(pagination.current_page - 1)"
            class="border rounded px-4 py-2 disabled:opacity-40"
        >
          Previous
        </button>

        <span>
          Page {{ pagination.current_page }}
          of {{ pagination.last_page }}
        </span>

        <button
            :disabled="pagination.current_page >= pagination.last_page"
            @click="changePage(pagination.current_page + 1)"
            class="border rounded px-4 py-2 disabled:opacity-40"
        >
          Next
        </button>
      </div>
    </template>
  </div>
</template>