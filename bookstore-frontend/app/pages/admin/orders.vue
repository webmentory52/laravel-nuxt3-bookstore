<script setup lang="ts">
definePageMeta({
  layout: 'admin',
  middleware: 'admin',
})

const { request } = useAdminApi()

const { data: orders, refresh } = await useAsyncData(
    'admin-orders',
    () => request<any>('orders')
)

const updateStatus = async (order: any) => {
  await request(`orders/${order.id}/status`, {
    method: 'PATCH',
    body: {
      status: order.status,
    },
  })

  await refresh()
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Orders</h1>

    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full text-left">
        <thead>
        <tr class="border-b">
          <th class="p-3">Order #</th>
          <th class="p-3">Customer</th>
          <th class="p-3">Total</th>
          <th class="p-3">Status</th>
          <th class="p-3">Items</th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders?.data" :key="order.id" class="border-b">
            <td class="p-3">{{ order.id }}</td>
            <td class="p-3">
              {{ order.customer_name }}
              <div class="text-sm text-gray-500">{{ order.phone }}</div>
            </td>
            <td class="p-3">{{ order.total }}</td>
            <td class="p-3">
              <select
                  v-model="order.status"
                  @change="updateStatus(order)"
                  class="border rounded p-2"
              >
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </td>
            <td class="p-3">
              <div v-for="item in order.items" :key="item.id">
                {{ item.book_title }} × {{ item.quantity }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>