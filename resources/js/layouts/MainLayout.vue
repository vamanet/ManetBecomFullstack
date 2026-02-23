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
  <div class="min-vh-100 bg-light">
    <!-- Navbar -->
    <Navbar @toggle-sidebar="toggleSidebar" :sidebar-collapsed="isSidebarCollapsed" />

    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="closeSidebar" @toggle-collapse="handleSidebarCollapse" />

    <!-- Main Content -->
    <main
      class="transition-all"
      :style="{ 
        paddingTop: '72px',
        marginLeft: isSidebarCollapsed ? '80px' : '256px',
        transition: 'margin-left 0.3s ease'
      }"
      style="min-height: 100vh;"
    >
      <div class="container-fluid p-4">
        <slot />
      </div>
    </main>
  </div>
</template>
