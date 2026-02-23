<script setup>
import { ref, computed } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Sidebar from '@/components/Sidebar.vue';
import { useAuthStore } from '@/stores/auth';

const auth = useAuthStore();
const isSidebarOpen = ref(false);

const isAuthenticated = computed(() => auth.isLoggedIn);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
  isSidebarOpen.value = false;
};
</script>

<template>
  <div v-if="isAuthenticated" class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <Navbar @toggle-sidebar="toggleSidebar" />

    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="closeSidebar" />

    <!-- Main Content -->
    <main
      class="pt-16 min-h-screen transition-all duration-300"
      :class="isSidebarOpen ? 'lg:pl-64' : 'lg:pl-20'"
    >
      <div class="p-6">
        <slot />
      </div>
    </main>
  </div>

  <!-- For non-authenticated pages, just render the slot -->
  <div v-else>
    <slot />
  </div>
</template>
