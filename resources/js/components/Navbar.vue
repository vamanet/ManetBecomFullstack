

<template>
  <nav 
    class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top"
    :style="{
      marginLeft: sidebarCollapsed ? '80px' : '256px',
      width: sidebarCollapsed ? 'calc(100% - 80px)' : 'calc(100% - 256px)',
      transition: 'margin-left 0.3s ease, width 0.3s ease'
    }"
  >
    <div class="container-fluid">
      <!-- Logo & Brand -->
      <button
        class="btn btn-light d-lg-none me-2"
        type="button"
        @click="$emit('toggle-sidebar')"
      >
        <svg class="bi" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      
      <router-link to="/" class="navbar-brand d-flex align-items-center m-2">
        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
          <strong>F</strong>
        </div>
        <span class="fw-bold">FoodShop</span>
      </router-link>

      <!-- User Menu -->
      <div class="dropdown ms-auto">
        <button
          @click="toggleUserMenu"
          class="btn btn-light d-flex align-items-center gap-2"
          type="button"
        >
          <div class="bg-primary bg-opacity-25 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <strong class="small">
              {{ auth.user?.name?.charAt(0).toUpperCase() || 'U' }}
            </strong>
          </div>
          <div class="text-start d-none d-md-block">
            <div class="small fw-semibold">{{ auth.user?.name || 'User' }}</div>
            <div class="text-muted" style="font-size: 0.75rem;">{{ auth.user?.email || 'user@example.com' }}</div>
          </div>
          <svg width="16" height="16" fill="currentColor" class="text-muted" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <ul v-if="isUserMenuOpen" class="dropdown-menu dropdown-menu-end show position-absolute" style="right: 0; top: 100%; margin-top: 0.5rem;">
          <li>
            <router-link
              to="/profile"
              class="dropdown-item d-flex align-items-center gap-2"
              @click="isUserMenuOpen = false"
            >
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profile
            </router-link>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <button
              @click="handleLogout"
              class="dropdown-item text-danger d-flex align-items-center gap-2"
            >
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </button>
          </li>
        </ul>
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

const props = defineProps({
  sidebarCollapsed: {
    type: Boolean,
    default: false
  }
});

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
