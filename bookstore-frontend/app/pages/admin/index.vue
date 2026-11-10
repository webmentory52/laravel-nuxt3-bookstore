<script setup lang="ts">
  definePageMeta({
    layout: 'admin',
    middleware: 'admin',
  })

  const { request } = useAdminApi()

  const { data: stats } = await useAsyncData(
      'admin-dashboard',
      () => request<any>('dashboard')
  )
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-500">Total Books</p>
        <h2 class="text-3xl font-bold">{{ stats?.total_books ?? 0 }}</h2>
      </div>

      <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-500">Total Orders</p>
        <h2 class="text-3xl font-bold">{{ stats?.total_orders ?? 0 }}</h2>
      </div>

      <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-500">Pending Orders</p>
        <h2 class="text-3xl font-bold">{{ stats?.pending_orders ?? 0 }}</h2>
      </div>

      <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-500">Total Revenue</p>
        <h2 class="text-3xl font-bold">{{ stats?.total_revenue ?? 0 }}</h2>
      </div>
    </div>
  </div>
</template>