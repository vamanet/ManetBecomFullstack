<template>
  <div class="">
  <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
      </li>
    </ul>
  </nav>
  </div>
</template>

<script setup lang="ts">
</script>
<style scoped>
.navbar {
  padding: 0.5rem 1rem;
  width: calc(100% - 280px);
  margin-left: 280px;
  position: fixed;
  top: 0;
  right: 0;
  z-index: 1001;
}

nav.navbar {
  background-color: white;
}
</style>