<template>
    <div class="container text-center">
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="d-flex align-items-center justify-content-center">
                <img :src="`${baseUrl}/img/foods/images.jpg`" alt="Delicious Food" class="img-fluid">
            </div>
            <div class="card-body">
                <h5 class="card-title">Delicious Food</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-primary fw-bold">$12.99</span>
                  <button class="btn btn-sm btn-primary">
                    <i class="bi bi-cart-plus"></i> Add
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="d-flex align-items-center justify-content-center">
              <img :src="`${baseUrl}/img/foods/images.jpg`" alt="Tasty Dish" class="img-fluid">
            </div>
            <div class="card-body">
                <h5 class="card-title">Tasty Dish</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-primary fw-bold">$15.99</span>
                  <button class="btn btn-sm btn-primary">
                    <i class="bi bi-cart-plus"></i> Add
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div style="height: 200px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" class="d-flex align-items-center justify-content-center">
              <img :src="`${baseUrl}/img/foods/images.jpg`" alt="Special Menu" class="img-fluid">
            </div>
            <div class="card-body">
                <h5 class="card-title">Special Menu</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-primary fw-bold">$18.99</span>
                  <button class="btn btn-sm btn-primary">
                    <i class="bi bi-cart-plus"></i> Add
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div style="height: 200px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);" class="d-flex align-items-center justify-content-center">
              <img :src="`${baseUrl}/img/foods/images.jpg`" alt="Chef's Choice" class="img-fluid">
            </div>
            <div class="card-body">
                <h5 class="card-title">Chef's Choice</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-primary fw-bold">$22.99</span>
                  <button class="btn btn-sm btn-primary">
                    <i class="bi bi-cart-plus"></i> Add
                  </button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</template>

<script setup>
const baseUrl = window.location.origin;
</script>