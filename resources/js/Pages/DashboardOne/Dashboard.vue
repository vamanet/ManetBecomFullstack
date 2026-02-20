<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Profile</h2>
        <div v-if="loading" class="text-gray-500">Loading...</div>
        <div v-else-if="user">
            <p><strong>Name:</strong> {{ user.name }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Joined:</strong> {{ formatDate(user.created_at) }}</p>
        </div>
        <div v-else class="text-red-500">Failed to load user data.</div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/components/AppLayout.vue'
import { reactive,ref } from 'vue'

interface User {
  name: string
  email: string
  created_at: string
}

const loading = ref(false)
const user = ref<User | null>(null)

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString()
}
</script>