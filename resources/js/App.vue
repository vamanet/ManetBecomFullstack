<template>
  <div id="app" class="min-h-screen bg-gray-100">
    <MainLayoutDashboard v-if="!isGuestRoute">
      <router-view />
    </MainLayoutDashboard>
    <router-view v-else />
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import MainLayoutDashboard from '@/layout/MainLayoutDashboard.vue'

const route = useRoute()

const isGuestRoute = computed(() => route.meta.requiresGuest)

onMounted(() => {
  console.log('✓ App.vue mounted successfully')
  console.log('✓ Router is ready')
})
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
