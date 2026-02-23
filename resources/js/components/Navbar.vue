

<template>
  <nav class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-50">
    <div class="flex items-center justify-between h-full px-4">
      <!-- Logo & Brand -->
      <div class="flex items-center gap-3">
        <button
          class="p-2 rounded-lg hover:bg-gray-100 lg:hidden"
          @click="$emit('toggle-sidebar')"
        >
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <router-link to="/" class="flex items-center gap-2">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-sm">A</span>
          </div>
          <span class="text-xl font-semibold text-gray-800">FoodShop</span>
        </router-link>
      </div>

      <!-- Navigation Links (Desktop) -->
      <!-- <div class="hidden lg:flex items-center gap-6">
        <router-link
          to="/"
          class="text-gray-600 hover:text-indigo-600 transition-colors font-medium"
        >
          Dashboard
        </router-link>
      </div> -->

      <!-- User Menu -->
      <div class="relative">
        <button
          @click="toggleUserMenu"
          class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
            <span class="text-indigo-600 font-medium text-sm">
              {{ auth.user?.name?.charAt(0).toUpperCase() || 'U' }}
            </span>
          </div>
          <div class="hidden md:block text-left">
            <p class="text-sm font-medium text-gray-800">{{ auth.user?.name || 'User' }}</p>
            <p class="text-xs text-gray-500">{{ auth.user?.email || 'user@example.com' }}</p>
          </div>
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div
          v-if="isUserMenuOpen"
          class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
        >
          <router-link
            to="/profile"
            class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"
            @click="isUserMenuOpen = false"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profile
          </router-link>
          <button
            @click="handleLogout"
            class="flex items-center gap-2 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>
<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();
const isUserMenuOpen = ref(false);

async function handleLogout() {
  isUserMenuOpen.value = false;
  try {
    await auth.logout();
    router.push('/login');
  } catch (error) {
    console.error('Logout error:', error);
    // Still redirect to login even if API call fails
    router.push('/login');
  }
}

const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value;
};
</script>
