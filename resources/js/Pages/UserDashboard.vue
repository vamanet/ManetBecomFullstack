<template>
  <AppLayout class="container">
    <div v-if="loading" class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-center text-gray-600">Loading...</p>
        </div>
      </div>
    </div>

    <div v-else-if="user" class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-4 py-6 bg-white sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">
              Welcome, {{ user.name }}!
            </h1>
            <p class="mt-2 text-gray-600">
              You are successfully logged in.
            </p>
          </div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900">Email</h3>
            <p class="mt-2 text-gray-600">{{ user.email }}</p>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900">Member Since</h3>
            <p class="mt-2 text-gray-600">{{ formatDate(user.created_at) }}</p>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <router-link
              to="/profile"
              class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
            >
              Edit Profile
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-center text-red-600">Unable to load user data</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AppLayout from '@/components/AppLayout.vue'

interface User {
  id: number
  name: string
  email: string
  created_at: string
}

const user = ref<User | null>(null)
const loading = ref(true)

const fetchUser = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    if (!token) {
      console.log('No auth token found')
      return
    }

    const response = await fetch('/api/me', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    })

    if (!response.ok) {
      console.error('Failed to fetch user:', response.status)
      return
    }

    const data = await response.json()
    user.value = data.user
  } catch (error) {
    console.error('Error fetching user:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (date: string): string => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

onMounted(() => {
  fetchUser()
})
</script>

<style scoped>
.container {
    margin-left: 265px;
    width: 80%;
    margin-top: 10px;
}
</style>
