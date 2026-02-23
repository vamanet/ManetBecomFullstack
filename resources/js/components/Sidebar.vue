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

defineEmits(['close']);

const menuItems = [
  {
    name: 'Dashboard',
    icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    route: '/',
  },
  {
    name: 'Users',
    icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    route: '/users',
  },
  {
    name: 'Products',
    icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
    route: '/products',
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
  return route.path === itemRoute;
};

const sidebarClasses = computed(() => {
  return {
    'w-64': !isCollapsed.value,
    'w-20': isCollapsed.value,
  };
});

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
};
</script>

<template>
  <div>
    <!-- Overlay for mobile -->
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black/50 z-40 lg:hidden"
      @click="$emit('close')"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed top-16 left-0 h-screen bg-white border-r border-gray-200 z-40 transition-all duration-300',
        sidebarClasses,
        isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
      ]"
    >
      <div class="flex flex-col h-full">
        <!-- Toggle Button (Desktop) -->
        <button
          @click="toggleCollapse"
          class="hidden lg:flex absolute -right-3 top-6 w-6 h-6 bg-white border border-gray-300 rounded-full items-center justify-center shadow-md hover:bg-gray-50 hover:border-gray-400 transition-all"
        >
          <svg
            class="w-3 h-3 text-gray-500 transition-transform"
            :class="{ 'rotate-180': isCollapsed }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <!-- Main Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
          <ul class="space-y-1">
            <li v-for="item in menuItems" :key="item.name">
              <router-link
                :to="item.route"
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200',
                  isActive(item.route)
                    ? 'bg-indigo-50 text-indigo-600 font-semibold'
                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                ]"
                :title="isCollapsed ? item.name : ''"
              >
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                </svg>
                <span v-if="!isCollapsed" class="font-medium">{{ item.name }}</span>
              </router-link>
            </li>
          </ul>
        </nav>

        <!-- Bottom Menu -->
        <div class="border-t border-gray-200 py-4 px-3">
          <ul class="space-y-1">
            <li v-for="item in bottomMenuItems" :key="item.name">
              <router-link
                :to="item.route"
                :class="[
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200',
                  isActive(item.route)
                    ? 'bg-indigo-50 text-indigo-600 font-semibold'
                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                ]"
                :title="isCollapsed ? item.name : ''"
              >
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                </svg>
                <span v-if="!isCollapsed" class="font-medium">{{ item.name }}</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </aside>
  </div>
</template>
