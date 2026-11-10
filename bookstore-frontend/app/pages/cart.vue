<script setup lang="ts">
const {
  cart,
  cartTotal,
  updateQuantity,
  removeFromCart
} = useCart()

const loading = ref(true);

onMounted(() => {
  loading.value = false;
})

</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-3">
      Shopping Cart
    </h1>

    <div v-if="loading" class="text-center py-16">
      <p class="text-gray-500 mb-5">
        Loading...
      </p>

    </div>

    <div v-else-if="cart.length === 0 && !loading" class="text-center py-16">
      <p class="text-gray-500 mb-5">
        Your shopping cart is empty.
      </p>

      <NuxtLink
          to="/books"
          class="bg-indigo-700 text-white px-6 py-3 rounded-lg"
      >
        Browse Books
      </NuxtLink>
    </div>

    <div v-else class="grid grid-cols-2 lg:grid-cols-3 gap-3">

      <!-- Cart Items -->
      <div class="lg:col-span-2 space-y-4">

        <div
            v-for="item in cart"
            :key="item.book_id"
            class="flex gap-4 border rounded-lg p-4"
        >
          <img
              v-if="item.cover_image"
              :src="item.cover_image"
              class="w-20 h-28 object-cover rounded"
          />

          <div
              v-else
              class="w-20 h-28 bg-gray-100 rounded"
          />

          <div class="flex-1">
            <NuxtLink
                :to="`/books/${item.slug}`"
                class="font-semibold text-lg"
            >
              {{ item.title }}
            </NuxtLink>

            <p class="text-indigo-700 font-bold mt-2">
              ${{ item.price.toFixed(2) }}
            </p>

            <div class="flex items-center gap-3 mt-3">
              <input
                  type="number"
                  min="1"
                  max="20"
                  :value="item.quantity"
                  @change="updateQuantity(
                  item.book_id,
                  Math.min(20, Math.max(1, Number(($event.target as HTMLInputElement).value) || 1))
                )"
                  class="border rounded w-16 px-2 py-1"
              />

              <button
                  @click="removeFromCart(item.book_id)"
                  class="text-red-600 text-sm"
              >
                Remove
              </button>
            </div>
          </div>

          <div class="font-semibold">
            ${{ (item.price * item.quantity).toFixed(2) }}
          </div>
        </div>

      </div>

      <!-- Cart Summary -->
      <div class="border rounded-lg px-5 py-3 h-fit">
        <h2 class="text-xl font-bold mb-5">
          Order Summary
        </h2>

        <div class="flex justify-between mb-4">
          <span>Subtotal</span>

          <span class="font-bold">
            ${{ cartTotal.toFixed(2) }}
          </span>
        </div>

        <p class="text-sm text-gray-500 mb-5">
          Shipping costs will be confirmed when placing your order.
        </p>

        <NuxtLink
            to="/checkout"
            class="block text-center bg-indigo-700 text-white
                 py-3 rounded-lg"
        >
          Proceed to Checkout
        </NuxtLink>
      </div>

    </div>
  </div>
</template>