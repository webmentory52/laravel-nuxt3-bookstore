<script setup lang="ts">
const {cartCount} = useCart()
</script>

<template>
  <div>
    <header class="bg-white shadow-sm">
      <nav class="container mx-auto px-4 py-5 flex justify-between">
        <NuxtLink to="/" class="text-2xl font-bold text-indigo-700">
          BookStore
        </NuxtLink>

        <div class="flex gap-6">
          <NuxtLink to="/">Home</NuxtLink>
          <NuxtLink to="/books">Books</NuxtLink>
          <NuxtLink to="/cart">
            Cart ({{ cartCount }})
          </NuxtLink>
        </div>
      </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
      <slot />
    </main>
  </div>
</template>