<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import MainLayout from '@/layouts/MainLayout.vue';

const route = useRoute();
const isGuestRoute = computed(() => route.meta.guest);
</script>

<template>
  <MainLayout v-if="!isGuestRoute">
    <router-view />
  </MainLayout>
  <router-view v-else />
</template>
