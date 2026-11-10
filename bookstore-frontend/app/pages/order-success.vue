<script setup lang="ts">
const route = useRoute()

const orderId = computed(() => route.query.id)
</script>

<template>
  <div class="max-w-xl mx-auto text-center py-16">

    <div class="text-green-600 text-4xl mb-6">
      ✓
    </div>

    <h1 class="text-3xl font-bold mb-4">
      Order Placed Successfully!
    </h1>

    <p class="text-gray-600 mb-4">
      Thank you for shopping with us.
      Your order has been received.
    </p>

    <p class="font-semibold mb-4">
      Order Number: #{{ orderId }}
    </p>

    <NuxtLink
        to="/books"
        class="inline-block bg-indigo-700 text-white px-8 py-3 rounded-lg"
    >
      Continue Shopping
    </NuxtLink>

  </div>
</template>