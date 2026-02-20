<template>
  <div class="sidebar bg-light border-end vh-100 p-3">
    <div class="sidebar-header mb-4">
      <h6 class="text-uppercase text-muted fw-semibold mb-3">Main Menu</h6>
    </div>

    <nav class="nav flex-column gap-1">
      <a class="nav-link active d-flex align-items-center rounded px-3 py-2" href="/dashboard">
         <i class="bi bi-bag-dash-fill"></i>
        <span>Dashboard</span>
      </a>

      <a class="nav-link d-flex align-items-center rounded px-3 py-2" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-folder me-2" viewBox="0 0 16 16">
          <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19z"/>
        </svg>
        <span>Projects</span>
      </a>

      <a class="nav-link d-flex align-items-center rounded px-3 py-2" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people me-2" viewBox="0 0 16 16">
          <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
        </svg>
        <span>Team</span>
      </a>

      <a class="nav-link d-flex align-items-center rounded px-3 py-2" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-graph-up me-2" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07z"/>
        </svg>
        <span>Analytics</span>
      </a>

      <hr class="my-3" />

      <h6 class="text-uppercase text-muted fw-semibold mb-3 small">Settings</h6>

      <a class="nav-link d-flex align-items-center rounded px-3 py-2" href="/userdashboard">
         <i class="bi bi-person"></i>
         <span>Profile</span>
      </a>

      <a class="nav-link d-flex align-items-center rounded px-3 py-2" href="#">
            <i class="bi bi-gear"></i>
        <span>Settings</span>
      </a>
    </nav>
  </div>
</template>

<script setup lang="ts">
</script>

<style scoped>
.sidebar {
  min-width: 250px;
  position: sticky;
  top: 0;
}

.nav-link {
  color: #6c757d;
  transition: all 0.2s;
}

.nav-link:hover {
  background-color: #e9ecef;
  color: #495057;
}

.nav-link.active {
  background-color: #0d6efd;
  color: white;
}

.nav-link.active:hover {
  background-color: #0b5ed7;
}
</style>