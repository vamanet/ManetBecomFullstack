<template>
  <div class="container">
    <div class="mb-5">
      <h1 style="font-size: 2.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem;">🍽️ Foods Menu</h1>
      <p style="color: #7f8c8d; font-size: 1rem;">Manage and organize your food items with ease</p>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex gap-2">
        <select v-model="perPage" @change="fetchFoods" class="form-select" style="width: auto;">
          <option :value="6">6 per page</option>
          <option :value="12">12 per page</option>
          <option :value="24">24 per page</option>
        </select>
      </div>
      <button class="btn btn-primary" data-bs-target="#foodModal" data-bs-toggle="modal" @click="openAddModal">
        + Add Food
      </button>
    </div>

    <!-- Foods Grid Display -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
      <div v-if="isLoadingFoods" class="col-12">
        <div style="text-align: center; padding: 3rem; color: #7f8c8d;">
          <div class="spinner-border text-primary mb-3" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p style="font-size: 1.1rem;">Loading foods...</p>
        </div>
      </div>
      <div v-else-if="!foods.length" class="col-12">
        <div style="text-align: center; padding: 3rem; background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%); border-radius: 12px;">
          <p style="font-size: 1.2rem; color: #7f8c8d; margin: 0;">📦 No foods yet. Click "Add Food" to get started!</p>
        </div>
      </div>
      <div v-else v-for="food in foods" :key="food.id" class="col">
        <div class="card h-100">
          <img v-if="food.image" :src="food.image" class="card-img-top" :alt="food.name" style="height: 200px; object-fit: cover;">
          <div v-else class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            <span class="text-muted">No Image</span>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <h5 class="card-title">{{ food.name }}</h5>
              <span :class="food.stock_status === 'in_stock' ? 'bg-success' : 'bg-danger'" class="badge">
                {{ food.stock_status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
              </span>
            </div>
            <p class="card-text">{{ food.description }}</p>
            <p class="card-text"><small class="text-muted">Size: {{ food.size }}</small></p>
            <p class="card-text"><small class="text-muted">Category: {{ food.category && food.category.name ? food.category.name : 'N/A' }}</small></p>
            <div class="d-flex justify-content-between align-items-center">
              <strong class="text-primary" style="font-size: 1.25rem;">${{ food.price }}</strong>
              <div class="btn-group">
                <button class="btn btn-sm btn-outline-primary" @click="openEditModal(food)" title="Edit">
                  ✏️
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="deleteFood(food.id)" title="Delete">
                  🗑️
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <nav v-if="pagination.last_page > 1" aria-label="Foods pagination">
      <ul class="pagination justify-content-center">
        <li :class="['page-item', { disabled: pagination.current_page === 1 }]">
          <button class="page-link" @click="changePage(pagination.current_page - 1)">Previous</button>
        </li>
        <li v-for="page in visiblePages" :key="page" :class="['page-item', { active: page === pagination.current_page }]">
          <button class="page-link" @click="changePage(page)">{{ page }}</button>
        </li>
        <li :class="['page-item', { disabled: pagination.current_page === pagination.last_page }]">
          <button class="page-link" @click="changePage(pagination.current_page + 1)">Next</button>
        </li>
      </ul>
    </nav>

    <!-- Modal Add/Edit Food-->
    <div ref="foodModal" class="modal fade" id="foodModal" aria-hidden="true" aria-labelledby="foodModalLabel"
      tabindex="-1">
      <div class="modal-dialog modal-xl ">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="foodModalLabel">{{ isEditing ? 'Edit Food' : 'Add New Food' }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form @submit.prevent="submitFood" enctype="multipart/form-data">
            <div class="modal-body modal-xl">
              <div class="container text-left">
                <div v-if="errorMessage" class="alert alert-danger" role="alert">
                  {{ errorMessage }}
                </div>
                <div v-if="successMessage" class="alert alert-success" role="alert">
                  {{ successMessage }}
                </div>
                <div class="row">
                  <!-- Form Inputs on Right -->
                  <div class="col-md-7">
                    <div class="mb-3">
                      <label for="foodName" class="form-label">Food Name</label>
                      <input v-model.trim="form.name" type="text" class="form-control" id="foodName" placeholder="Enter food name" required>
                    </div>
                    <div class="mb-3">
                      <label for="foodDescription" class="form-label">Description</label>
                      <textarea v-model.trim="form.description" class="form-control" id="foodDescription" placeholder="Enter description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="foodCategory" class="form-label">Category</label>
                      <select v-model="form.category_id" class="form-select" id="foodCategory" required>
                        <option value="">Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                          {{ category.name }}
                        </option>
                      </select>
                      <div v-if="!categories.length" class="form-text text-warning">
                        No categories available. Please create a category first.
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-4">
                        <label for="foodSize" class="form-label">Size</label>
                        <select v-model="form.size" class="form-select" id="foodSize" required>
                          <option value="Small">Small</option>
                          <option value="Medium">Medium</option>
                          <option value="Large">Large</option>
                        </select>
                      </div>
                      <div class="col-4">
                        <label for="foodPrice" class="form-label">Price</label>
                        <input v-model.number="form.price" type="number" class="form-control" id="foodPrice" placeholder="Enter price" min="0" step="0.01" required>
                      </div>
                      <div class="col-4">
                        <label for="stockStatus" class="form-label">Stock Status</label>
                        <select v-model="form.stock_status" class="form-select" id="stockStatus" required>
                          <option value="in_stock">In Stock</option>
                          <option value="out_of_stock">Out of Stock</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- File Upload on Left -->
                  <div class="col-md-5">
                    <div class="upload-container">
                      <div class="upload-header">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                          <g id="SVGRepo_iconCarrier">
                            <path
                              d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15"
                              stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                          </g>
                        </svg>
                        <p>Browse File to upload!</p>
                      </div>
                      <label for="file" class="upload-footer">
                        <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                          <g id="SVGRepo_iconCarrier">
                            <path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path>
                            <path d="M18.153 6h-.009v5.342H23.5v-.002z"></path>
                          </g>
                        </svg>
                        <p>{{ form.image_name || "Not selected file" }}</p>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                          <g id="SVGRepo_iconCarrier">
                            <path
                              d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z"
                              stroke="#000000" stroke-width="2"></path>
                            <path d="M19.5 5H4.5" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z" stroke="#000000"
                              stroke-width="2"></path>
                          </g>
                        </svg>
                      </label>
                      <input id="file" type="file" @change="handleFileChange" accept="image/*">
                    </div>
                    <!-- Image Preview -->
                    <div v-if="imagePreview" class="mt-3 text-center">
                      <img :src="imagePreview" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                      <button type="button" class="btn btn-sm btn-outline-danger ms-2" @click="removeImage">Remove</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit" :data-bs-dismiss="closeOnSuccess ? 'modal' : null" :disabled="isSubmitting || !categories.length">
                {{ isSubmitting ? "Saving..." : (isEditing ? "Update" : "Submit") }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, computed, onMounted } from "vue";
import axios from "axios";
import { Modal } from "bootstrap";

const form = reactive({
  id: null,
  name: "",
  description: "",
  category_id: "",
  size: "Small",
  price: "",
  stock_status: "in_stock",
  image: null,
  image_name: "",
});

const isSubmitting = ref(false);
const errorMessage = ref("");
const successMessage = ref("");
const closeOnSuccess = ref(false);
const foods = ref([]);
const categories = ref([]);
const isLoadingFoods = ref(false);
const foodModal = ref(null);
const isEditing = ref(false);
const imagePreview = ref(null);
const perPage = ref(12);
const pagination = reactive({
  current_page: 1,
  last_page: 1,
  total: 0,
});

const visiblePages = computed(() => {
  const pages = [];
  const current = pagination.current_page;
  const last = pagination.last_page;
  const delta = 2;
  
  for (let i = Math.max(1, current - delta); i <= Math.min(last, current + delta); i++) {
    pages.push(i);
  }
  return pages;
});

const handleFileChange = (event) => {
  const file = event.target.files?.[0];
  if (file) {
    form.image = file;
    form.image_name = file.name;
    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const removeImage = () => {
  form.image = null;
  form.image_name = "";
  imagePreview.value = null;
  // Reset file input
  const fileInput = document.getElementById('file');
  if (fileInput) fileInput.value = "";
};

const resetForm = () => {
  form.id = null;
  form.name = "";
  form.description = "";
  form.category_id = "";
  form.size = "Small";
  form.price = "";
  form.stock_status = "in_stock";
  form.image = null;
  form.image_name = "";
  imagePreview.value = null;
  isEditing.value = false;
  closeOnSuccess.value = false;
};

const fetchFoods = async () => {
  isLoadingFoods.value = true;
  errorMessage.value = "";
  try {
    const response = await axios.get(`/api/foods?per_page=${perPage.value}`);
    foods.value = response.data?.data?.data || response.data?.data || [];
    if (response.data?.meta) {
      pagination.current_page = response.data.meta.current_page;
      pagination.last_page = response.data.meta.last_page;
      pagination.total = response.data.meta.total;
    }
  } catch (error) {
    errorMessage.value = error?.response?.data?.message || "Failed to load foods.";
  } finally {
    isLoadingFoods.value = false;
  }
};

const fetchCategories = async () => {
  try {
    const response = await axios.get("/api/categories");
    categories.value = response.data?.data || [];
  } catch (error) {
    console.error("Failed to load categories:", error);
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= pagination.last_page) {
    pagination.current_page = page;
    fetchFoods();
  }
};

const openAddModal = () => {
  resetForm();
};

const openEditModal = (food) => {
  resetForm();
  isEditing.value = true;
  form.id = food.id;
  form.name = food.name;
  form.description = food.description;
  form.category_id = food.category_id;
  form.size = food.size;
  form.price = food.price;
  form.stock_status = food.stock_status;
  if (food.image) {
    imagePreview.value = food.image;
  }
};

const closeModal = () => {
  const modalEl = document.getElementById('foodModal');
  if (!modalEl) return;
  
  const instance = Modal.getInstance(modalEl);
  if (instance) {
    instance.hide();
  }
  resetForm();
};

const submitFood = async () => {
  isSubmitting.value = true;
  errorMessage.value = "";  
  successMessage.value = "";

  const formData = new FormData();
  formData.append("name", form.name);
  formData.append("description", form.description);
  formData.append("category_id", String(form.category_id));
  formData.append("size", form.size);
  formData.append("price", String(form.price));
  formData.append("stock_status", form.stock_status);
  if (form.image) {
    formData.append("image", form.image);
  }

  try {
    if (isEditing.value) {
      formData.append("_method", "PUT");
      await axios.post(`/api/foods/${form.id}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      successMessage.value = "Food updated successfully.";
    } else {
      await axios.post("/api/foods", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      successMessage.value = "Food created successfully.";
    }
    closeOnSuccess.value = true;
    
    resetForm();
    await fetchFoods();
    
    setTimeout(() => {
      closeModal();
      setTimeout(() => {
        successMessage.value = "";
        errorMessage.value = "";
      }, 300);
    }, 1000);
  } catch (error) {
    errorMessage.value = error?.response?.data?.message || "Failed to save food. Check inputs.";
  } finally {
    isSubmitting.value = false;
  }
};

const deleteFood = async (id) => {
  if (!confirm("Are you sure you want to delete this food item?")) return;
  
  try {
    await axios.delete(`/api/foods/${id}`);
    await fetchFoods();
  } catch (error) {
    alert(error?.response?.data?.message || "Failed to delete food.");
  }
};

onMounted(() => {
  fetchFoods();
  fetchCategories();
});
</script>

<style scoped>
.container {
  padding: 2rem 1rem;
  max-width: 1400px;
  margin: 0 auto;
}

.btn {
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  border-radius: 8px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
}

.btn-primary {
  background: linear-gradient(135deg, #0d6efd 0%, #0d5ce8 100%);
  border: none;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
}

.btn-outline-primary, .btn-outline-danger {
  padding: 0.25rem 0.5rem;
}

/* Cards Grid */
.card {
  border: none;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  height: 100%;
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.card-img-top {
  border-radius: 12px 12px 0 0;
  transition: transform 0.3s ease;
}

.card:hover .card-img-top {
  transform: scale(1.05);
}

.card-body {
  padding: 1.5rem;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.card-text {
  color: #555;
  font-size: 0.95rem;
  margin-bottom: 0.75rem;
  line-height: 1.5;
}

.badge {
  font-size: 0.75rem;
  padding: 0.5rem 0.75rem;
  border-radius: 50px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Upload Container */
.upload-container {
  height: 300px;
  width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  padding: 15px;
  gap: 10px;
  background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.02) 100%);
  border: 2px solid rgba(13, 110, 253, 0.1);
  transition: all 0.3s ease;
}

.upload-container:hover {
  border-color: rgba(13, 110, 253, 0.25);
  background: linear-gradient(135deg, rgba(13, 110, 253, 0.08) 0%, rgba(13, 110, 253, 0.04) 100%);
}

.upload-header {
  flex: 1;
  width: 100%;
  border: 2px dashed #0d6efd;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  transition: all 0.3s ease;
  color: #0d6efd;
}

.upload-container:hover .upload-header {
  background-color: rgba(13, 110, 253, 0.05);
}

.upload-header svg {
  height: 80px;
  margin-bottom: 0.5rem;
  opacity: 0.8;
}

.upload-header p {
  text-align: center;
  color: #0d6efd;
  font-weight: 600;
  font-size: 0.95rem;
  margin: 0;
}

.upload-footer {
  background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
  height: 60px;
  width: 100%;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.upload-footer:hover {
  background: linear-gradient(135deg, rgba(13, 110, 253, 0.2) 0%, rgba(13, 110, 253, 0.1) 100%);
}

.upload-footer svg {
  width: 24px;
  height: 24px;
  opacity: 0.8;
}

.upload-footer p {
  margin: 0;
  font-size: 0.9rem;
  color: #333;
}

.upload-container input[type="file"] {
  display: none;
}

/* Pagination */
.pagination {
  margin-top: 2rem;
}

.page-link {
  color: #0d6efd;
  border-radius: 8px;
  margin: 0 2px;
}

.page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.page-link:hover {
  color: #0d5ce8;
}
</style>
