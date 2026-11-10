<script setup lang="ts">
const props = defineProps<{
  book?: any
  categories: any[]
}>()

const emit = defineEmits<{
  submit: [form: FormData]
}>()

const form = reactive({
  title: props.book?.title || '',
  author: props.book?.author || '',
  description: props.book?.description || '',
  price: props.book?.price || '',
  stock: props.book?.stock || 0,
  category_id: props.book?.category_id || '',
  cover: null as File | null,
})

const submit = () => {
  const data = new FormData()

  Object.entries(form).forEach(([key, value]) => {
    if (value !== null) {
      data.append(key, value as string | Blob)
    }
  })

  emit('submit', data)
}
</script>

<template>
  <form @submit.prevent="submit" class="bg-white p-6 rounded shadow space-y-4">
    <input v-model="form.title" placeholder="Title" required class="w-full border p-3 rounded" />
    <input v-model="form.author" placeholder="Author" required class="w-full border p-3 rounded" />

    <textarea v-model="form.description" placeholder="Description" class="w-full border p-3 rounded" />

    <input v-model="form.price" type="number" min="0" step="0.01" placeholder="Price" required class="w-full border p-3 rounded" />
    <input v-model="form.stock" type="number" min="0" placeholder="Stock" required class="w-full border p-3 rounded" />

    <select v-model="form.category_id" required class="w-full border p-3 rounded">
      <option value="">Select category</option>
      <option v-for="category in categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>

    <input
        type="file"
        accept="image/*"
        @change="form.cover = ($event.target as HTMLInputElement).files?.[0] || null"
    />

    <button class="bg-black text-white px-5 py-3 rounded">Save Book</button>
  </form>
</template>