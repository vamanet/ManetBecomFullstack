<template>
  <div class="sidebar">
    <!-- Header/Logo -->
    <div class="sidebar-header">
      <div class="logo-section">
        <i class="bi bi-cloud"></i>
        <span class="logo-text">Drive.</span>
      </div>
    </div>

    <!-- Main Navigation -->
    <nav class="nav flex-column">
      <a class="nav-link active" href="/dashboard">
        <i class="bi bi-cloud"></i>
        <span>My Drive</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-folder"></i>
        <span>Shared Files</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-file-earmark"></i>
        <span>File Requests</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-star"></i>
        <span>Starred</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-trash"></i>
        <span>Trash</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-bar-chart"></i>
        <span>Statistics</span>
      </a>

      <a class="nav-link" href="#">
        <i class="bi bi-list-check"></i>
        <span>Task</span>
      </a>
    </nav>

    <!-- Storage Section -->
    <div class="storage-section">
      <div class="storage-info">
        <i class="bi bi-cloud"></i>
        <span>Storage</span>
        <span class="storage-percent">27%</span>
      </div>
      <div class="storage-bar">
        <div class="storage-used"></div>
      </div>
      <p class="storage-text">277/100 GB Used</p>
    </div>

    <!-- Logout -->
    <a class="nav-link logout-link" href="#">
      <i class="bi bi-box-arrow-right"></i>
      <span>Logout</span>
    </a>
  </div>
</template>

<script setup lang="ts">
</script>

<style scoped>
.sidebar {
  min-width: 280px;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  background: linear-gradient(135deg, #1a2940 0%, #2d3e50 100%);
  overflow-y: auto;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  padding: 2rem 1rem;
  color: white;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
}

.sidebar-header {
  margin-bottom: 3rem;
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 1.5rem;
  font-weight: 700;
  padding: 0.5rem;
}

.logo-section i {
  color: #ffc107;
  font-size: 1.75rem;
}

.logo-text {
  color: white;
  letter-spacing: 0.05em;
}

nav.nav {
  flex: 1;
  gap: 0.5rem;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 1rem;
  color: #b0b8c1;
  text-decoration: none;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  font-weight: 500;
}

.nav-link i {
  font-size: 1.25rem;
  width: 1.5rem;
  text-align: center;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  padding-left: 1.25rem;
}

.nav-link.active {
  background-color: rgba(255, 255, 255, 0.15);
  color: white;
  border-left: 3px solid #ffc107;
  padding-left: calc(1rem - 3px);
}

.storage-section {
  margin: 2rem 0;
  padding: 1.25rem;
  background-color: rgba(255, 255, 255, 0.08);
  border-radius: 0.75rem;
}

.storage-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  color: #b0b8c1;
  font-size: 0.875rem;
}

.storage-info i {
  color: #ffc107;
}

.storage-percent {
  margin-left: auto;
  font-weight: 600;
  color: white;
}

.storage-bar {
  width: 100%;
  height: 6px;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 3px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.storage-used {
  height: 100%;
  width: 27%;
  background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
  border-radius: 3px;
}

.storage-text {
  font-size: 0.75rem;
  color: #7d8a99;
  margin: 0;
}

.logout-link {
  margin-top: auto;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding-top: 1rem;
}

/* Scrollbar styling */
.sidebar::-webkit-scrollbar {
  width: 6px;
}

.sidebar::-webkit-scrollbar-track {
  background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}
</style>