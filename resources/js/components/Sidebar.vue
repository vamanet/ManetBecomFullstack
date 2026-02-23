

<template>
  <div>
    <!-- Overlay for mobile -->
    <div
      v-if="isOpen"
      class="modal-backdrop fade show d-lg-none"
      @click="$emit('close')"
      style="z-index: 1040;"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'bg-white border-end shadow-sm position-fixed start-0 h-100 d-flex flex-column transition-all',
        sidebarClasses,
        isOpen ? '' : 'd-none d-lg-flex'
      ]"
      :style="{ ...sidebarStyle, zIndex: 1045, transition: 'width 0.3s ease' }"
    >
      <!-- Toggle Button (Desktop) -->
      <button
        @click="toggleCollapse"
        class="btn btn-sm btn-light rounded-circle d-none d-lg-flex align-items-center justify-content-center position-absolute shadow-sm"
        style="width: 28px; height: 28px; right: -14px; top: 24px;"
      >
        <svg
          width="12"
          height="12"
          class="transition-transform"
          :style="{ transform: isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)' }"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <!-- Main Menu -->
      <nav class="flex-grow-1 overflow-auto py-3 px-2">
        <ul class="nav flex-column gap-1">
          <li v-for="item in menuItems" :key="item.name" class="nav-item">
            <router-link
              :to="item.route"
              :class="[
                'nav-link d-flex align-items-center gap-3 rounded',
                isActive(item.route)
                  ? 'bg-primary bg-opacity-10 text-primary fw-semibold'
                  : 'text-secondary'
              ]"
              :title="isCollapsed ? item.name : ''"
            >
              <svg class="flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
              </svg>
              <span v-if="!isCollapsed" class="text-truncate">{{ item.name }}</span>
            </router-link>
          </li>
        </ul>
      </nav>

      <!-- Bottom Menu -->
      <div class="border-top py-3 px-2 mt-auto">
        <ul class="nav flex-column gap-1">
          <li v-for="item in bottomMenuItems" :key="item.name" class="nav-item">
            <router-link
              :to="item.route"
              :class="[
                'nav-link d-flex align-items-center gap-3 rounded',
                isActive(item.route)
                  ? 'bg-primary bg-opacity-10 text-primary fw-semibold'
                  : 'text-secondary'
              ]"
              :title="isCollapsed ? item.name : ''"
            >
              <svg class="flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
              </svg>
              <span v-if="!isCollapsed" class="text-truncate">{{ item.name }}</span>
            </router-link>
          </li>
        </ul>
      </div>
    </aside>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const isCollapsed = ref(false);

defineProps({
  isOpen: {
    type: Boolean,
    default: true,
  },
});

const menuItems = [
  {
    name: 'Dashboard',
    icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    route: '/dashboardfood',
  },
  {
      name: 'Foods',
      icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
      route: '/foods',
    },
    {
        name: 'Orders',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
        route: '/orders',
    },
    {
        name: 'Analytics',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        route: '/analytics',
    },
    {
      name: 'Users',
      icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
      route: '/users',
    },
];

const bottomMenuItems = [
  {
    name: 'Settings',
    icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
    route: '/settings',
  },
  {
    name: 'Help',
    icon: 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    route: '/help',
  },
];

const isActive = (itemRoute) => {
  // Check exact match
  if (route.path === itemRoute) return true;
  
  // Special case: Match both '/' and '/dashboardfood' for Dashboard
  if (itemRoute === '/dashboardfood' && route.path === '/') return true;
  
  return false;
};

const sidebarClasses = computed(() => {
  const width = isCollapsed.value ? '80px' : '256px';
  return {
    'sidebar-expanded': !isCollapsed.value,
    'sidebar-collapsed': isCollapsed.value,
  };
});

const sidebarStyle = computed(() => ({
  width: isCollapsed.value ? '80px' : '256px'
}));

const emit = defineEmits(['close', 'toggle-collapse']);

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
  emit('toggle-collapse', isCollapsed.value);
};
</script>
