<template>
<div class="container text-center">
  <div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div class="text-start">
                  <h5 class="card-title text-muted mb-3">Orders</h5>
                  <h2 class="text-primary mb-0">12</h2>
                </div>
                <div class="bg-primary bg-opacity-10 rounded p-2">
                  <i class="bi bi-cart-check text-primary" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div class="text-start">
                  <h5 class="card-title text-muted mb-3">Revenue</h5>
                  <h2 class="text-success mb-0">$2,450</h2>
                </div>
                <div class="bg-success bg-opacity-10 rounded p-2">
                  <i class="bi bi-currency-dollar text-success" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div class="text-start">
                  <h5 class="card-title text-muted mb-3">Customers</h5>
                  <h2 class="text-info mb-0">245</h2>
                </div>
                <div class="bg-info bg-opacity-10 rounded p-2">
                  <i class="bi bi-people text-info" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div class="text-start">
                  <h5 class="card-title text-muted mb-3">Products</h5>
                  <h2 class="text-warning mb-0">89</h2>
                </div>
                <div class="bg-warning bg-opacity-10 rounded p-2">
                  <i class="bi bi-box-seam text-warning" style="font-size: 1.5rem;"></i>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">
            <i class="bi bi-graph-up me-2"></i>Recent Activity
          </h5>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">
            <i class="bi bi-bell me-2"></i>Notifications
          </h5>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
const baseUrl = window.location.origin;
</script>