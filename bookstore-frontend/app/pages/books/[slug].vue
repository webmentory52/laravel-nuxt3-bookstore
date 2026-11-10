<script setup lang="ts">
const route = useRoute()
const config = useRuntimeConfig()

const slug = computed(() => String(route.params.slug))

const { data: response, pending, error } = await useFetch<{data: any}>(() => `${config.public.apiBase}/books/${slug.value}`)

const {addToCart} = useCart();

function handleAddToCart() {
  addToCart(book.value);

  alert("Book added to cart!");

  navigateTo('/cart');
}

const book = computed(() => response.value?.data)
</script>

<template>
  <div>
    <div v-if="pending" class="text-center py-10">
      Loading book details...
    </div>

    <div v-else-if="error" class="text-center py-10">
      Book not found.
    </div>

    <div
        v-else-if="book"
        class="grid grid-cols-2 md:grid-cols-1 gap-2"
    >
      <!-- Book Cover -->
      <div class="bg-gray-100 rounded-xl overflow-hidden aspect-[3/4] max-w-md">
        <img
            v-if="book.cover_image"
            :src="book.cover_image"
            :alt="book.title"
            class="w-full h-full object-cover"
        />

        <div
            v-else
            class="h-full flex items-center justify-center text-gray-400"
        >
          No Cover Available
        </div>
      </div>

      <!-- Book Information -->
      <div>
        <NuxtLink
            :to="`/books?category=${book.category.slug}`"
            class="text-indigo-700 mb-4 inline-block"
        >
          {{ book.category.name }}
        </NuxtLink>

        <h1 class="text-3xl font-bold mb-3">
          {{ book.title }}
        </h1>

        <p class="text-gray-500 mb-6">
          By {{ book.author }}
        </p>

        <p class="text-2xl font-bold text-indigo-700 mb-6">
          ${{ book.price }}
        </p>

        <p class="text-gray-600 leading-7 mb-6">
          {{ book.description }}
        </p>

        <p class="mb-6">
          <span v-if="book.stock > 0" class="text-green-600">
            In Stock
          </span>

          <span v-else class="text-red-600">
            Out of Stock
          </span>
        </p>

        <button
            :disabled="book.stock < 1"
            @click="handleAddToCart()"
            class="bg-indigo-700 text-white px-8 py-3 rounded-lg
         disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ book.stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
      </div>
    </div>
  </div>
</template>