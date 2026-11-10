<script setup lang="ts">
import type {Book} from "~/inc/types.ts";

defineProps<{ book: Book }>()
</script>

<template>
  <NuxtLink
      :to="`/books/${book.slug}`"
      class="block bg-white rounded-lg shadow-sm overflow-hidden
           hover:shadow-lg transition"
  >
    <div class="aspect-[3/4] bg-gray-100">
      <img
          v-if="book.cover_image"
          :src="book.cover_image"
          :alt="book.title"
          class="w-full h-full object-cover"
      />

      <div
          v-else
          class="w-full h-full flex items-center justify-center text-gray-400"
      >
        No Cover
      </div>
    </div>

    <div class="p-4">
      <p class="text-sm text-indigo-600 mb-2">
        {{ book.category?.name }}
      </p>

      <h3 class="font-semibold text-lg mb-1">
        {{ book.title }}
      </h3>

      <p class="text-sm text-gray-500 mb-3">
        {{ book.author }}
      </p>

      <p class="font-bold text-indigo-700">
        ${{ book.price }}
      </p>
    </div>
  </NuxtLink>
</template>