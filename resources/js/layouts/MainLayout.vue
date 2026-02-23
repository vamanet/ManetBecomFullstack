<script setup>
import { ref } from 'vue';
import Navbar from '@/components/Navbar.vue';
import Sidebar from '@/components/Sidebar.vue';

const isSidebarOpen = ref(true);
const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
  isSidebarOpen.value = false;
};

const handleSidebarCollapse = (collapsed) => {
  isSidebarCollapsed.value = collapsed;
};
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <Navbar @toggle-sidebar="toggleSidebar" />

    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="closeSidebar" @toggle-collapse="handleSidebarCollapse" />

    <!-- Main Content -->
    <main
      class="pt-16 min-h-screen transition-all duration-300"
      :class="isSidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'"
    >
      <div class="p-6 lg:p-8">
        <slot />
      </div>
    </main>
  </div>
</template>
