<script setup lang="ts">
const { cart, cartTotal, clearCart } = useCart()

const config = useRuntimeConfig()
const router = useRouter()

const loading = ref(false)
const cartLoading = ref(true)
const errorMessage = ref('')

const form = reactive({
  customer_name: '',
  email: '',
  phone: '',
  address: '',
})

async function placeOrder() {
  if (cart.value.length === 0) {
    return
  }

  loading.value = true
  errorMessage.value = ''

  try {
    const response = await $fetch<any>(
        `${config.public.apiBase}/orders`,
        {
          method: 'POST',
          body: {
            ...form,
            items: cart.value.map(item => ({
              book_id: item.book_id,
              quantity: item.quantity,
            })),
          },
        }
    )

    // Empty the cart after successful checkout
    clearCart()

    // Navigate to confirmation page
    await router.push(
        `/order-success?id=${response.order.id}`
    )

  } catch (error: any) {
    errorMessage.value =
        error.data?.message || 'Unable to place your order.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  cartLoading.value = false;
});
</script>

<template>
  <div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold mb-3">
      Checkout
    </h1>

    <div v-if="cartLoading" class="text-center py-10">
      <p class="mb-5">Loading cart...</p>
    </div>

    <div v-else-if="cart.length === 0 && !cartLoading" class="text-center py-10">
      <p class="mb-5">Your cart is empty.</p>

      <NuxtLink to="/books" class="text-indigo-700">
        Browse Books
      </NuxtLink>
    </div>

    <form v-else @submit.prevent="placeOrder" class="grid grid-cols-2 sm:grid-cols-1 gap-3">

      <div class="border rounded-lg px-4 py-5 mb-6">

        <h2 class="text-xl font-bold mb-5">
          Delivery Information
        </h2>

        <div class="space-y-4">

          <input
              v-model="form.customer_name"
              type="text"
              placeholder="Full Name"
              required
              class="w-full border rounded-lg px-4 py-3"
          />

          <input
              v-model="form.email"
              type="email"
              placeholder="Email Address"
              required
              class="w-full border rounded-lg px-4 py-3"
          />

          <input
              v-model="form.phone"
              type="tel"
              placeholder="Phone Number"
              required
              class="w-full border rounded-lg px-4 py-3"
          />

          <textarea
              v-model="form.address"
              placeholder="Delivery Address"
              required
              rows="4"
              class="w-full border rounded-lg px-4 py-3"
          />

        </div>
      </div>

      <!-- Order Summary -->
      <div class="border rounded-lg px-4 py-5 mb-6">

        <h2 class="text-xl font-bold mb-4">
          Order Summary
        </h2>

        <div
            v-for="item in cart"
            :key="item.book_id"
            class="flex justify-between mb-3"
        >
          <span>
            {{ item.title }} × {{ item.quantity }}
          </span>

          <span>
            ${{ (item.price * item.quantity).toFixed(2) }}
          </span>
        </div>

        <hr class="my-4" />

        <div class="flex justify-between font-bold text-lg">
          <span>Total</span>

          <span>${{ cartTotal.toFixed(2) }}</span>
        </div>

        <p class="text-sm text-gray-500 mt-4">
          Payment method: Cash on Delivery
        </p>

      </div>

      <p v-if="errorMessage" class="text-red-600 mb-4">
        {{ errorMessage }}
      </p>

      <button
          type="submit"
          :disabled="loading"
          class="w-full bg-indigo-700 text-white py-3 rounded-lg
               disabled:opacity-50"
      >
        {{ loading ? 'Placing Order...' : 'Place Order' }}
      </button>

    </form>
  </div>
</template>