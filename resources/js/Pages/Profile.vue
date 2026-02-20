<template>
  <AppLayout>
    <div v-if="loading" class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-center text-gray-600">Loading profile...</p>
        </div>
      </div>
    </div>

    <div v-else-if="user" class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-4 py-6 bg-white sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="mt-2 text-gray-600">Update your account information</p>
          </div>
        </div>

        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <form @submit.prevent="updateProfile" class="space-y-6">
            <div v-if="successMessage" class="rounded-md bg-green-50 p-4">
              <p class="text-sm text-green-800">{{ successMessage }}</p>
            </div>

            <div v-if="errors.general" class="rounded-md bg-red-50 p-4">
              <p class="text-sm text-red-800">{{ errors.general }}</p>
            </div>

            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">
                Full Name
              </label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                placeholder="John Doe"
              />
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                {{ errors.name[0] }}
              </p>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">
                Email Address
              </label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                placeholder="you@example.com"
              />
              <p v-if="errors.email" class="mt-1 text-sm text-red-600">
                {{ errors.email[0] }}
              </p>
            </div>

            <div class="flex space-x-4">
              <button
                type="submit"
                :disabled="loading"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:opacity-50"
              >
                {{ loading ? 'Saving...' : 'Save Changes' }}
              </button>

              <router-link
                to="/userdashboard"
                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
              >
                Back to Dashboard
              </router-link>
            </div>
          </form>
        </div>

        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Account Information</h2>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">User ID</p>
              <p class="text-lg font-medium text-gray-900">{{ user.id }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Member Since</p>
              <p class="text-lg font-medium text-gray-900">{{ formatDate(user.created_at) }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Last Updated</p>
              <p class="text-lg font-medium text-gray-900">{{ formatDate(user.updated_at) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-center text-red-600">Unable to load user profile</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import AppLayout from '@/components/AppLayout.vue'

interface User {
  id: number
  name: string
  email: string
  created_at: string
  updated_at: string
}

const user = ref<User | null>(null)
const loading = ref(true)
const successMessage = ref('')

const form = reactive({
  name: '',
  email: '',
})

const errors = reactive<Record<string, string[]>>({
  general: '',
  name: [],
  email: [],
})

const fetchUser = async () => {
  try {
    loading.value = true
    const token = localStorage.getItem('auth_token')
    if (!token) {
      console.log('No auth token found')
      errors.general = 'Not authenticated'
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
      errors.general = 'Failed to load user data'
      return
    }

    const data = await response.json()
    user.value = data.user
    form.name = data.user.name
    form.email = data.user.email
  } catch (error) {
    console.error('Error fetching user:', error)
    errors.general = 'An error occurred while loading your profile'
  } finally {
    loading.value = false
  }
}

const updateProfile = async () => {
  loading.value = true
  successMessage.value = ''
  Object.keys(errors).forEach(key => {
    errors[key] = []
  })

  try {
    const token = localStorage.getItem('auth_token')
    if (!token) {
      errors.general = 'Not authenticated'
      return
    }

    const response = await fetch('/api/profile', {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
      body: JSON.stringify(form),
    })

    const data = await response.json()

    if (!response.ok) {
      if (data.errors) {
        Object.assign(errors, data.errors)
      } else {
        errors.general = data.message || 'Failed to update profile'
      }
      return
    }

    user.value = data.user
    successMessage.value = 'Profile updated successfully!'
  } catch (error) {
    console.error('Error updating profile:', error)
    errors.general = 'An error occurred while updating your profile'
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