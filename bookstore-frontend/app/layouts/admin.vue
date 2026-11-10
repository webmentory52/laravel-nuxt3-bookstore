<template>
  <div class="min-h-screen bg-gray-100">
    <aside class="fixed left-0 top-0 h-full w-56 bg-gray-900 text-white p-5">
      <h2 class="text-xl font-bold mb-8">Bookstore Admin</h2>

      <nav class="space-y-4">
        <NuxtLink to="/admin" class="block">Dashboard</NuxtLink>
        <NuxtLink to="/admin/books" class="block">Books</NuxtLink>
        <NuxtLink to="/admin/categories" class="block">Categories</NuxtLink>
        <NuxtLink to="/admin/orders" class="block">Orders</NuxtLink>
      </nav>
    </aside>

    <main class="ml-56 p-8">
      <slot />
    </main>
  </div>
</template>