<template>
    <div :data-bs-theme="currentThemeAttr" class="min-vh-100 d-flex flex-column app-shell">
        <Navbar  />

        <div class="d-flex flex-grow-1 layout-body">
            <Sibar class="{ 'd-none d-md-block': !sidebarOpen }" />

            <main class="flex-grow-1 main-content" :class="{ 'iframe-mode': isIframeMode }">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '@/components/DashboardLayout/Navbar.vue';
import Sibar from '@/components/DashboardLayout/Sibar.vue';

const route = useRoute()
const theme = ref('light')
const sidebarOpen = ref(true)
const isIframeMode = ref(false)

const currentThemeAttr = computed(() => theme.value)

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
}

const updateIframeMode = () => {
    isIframeMode.value = route.query.iframe === '1'
}

onMounted(() => {
    updateIframeMode()
    window.addEventListener('resize', updateIframeMode)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateIframeMode)
})

watch(
    () => route.query.iframe,
    () => {
        updateIframeMode()
    }
)
</script>