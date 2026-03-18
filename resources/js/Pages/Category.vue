<template>
    <div class="container">
        <div class="mb-5">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 0.5rem;">📂 Categories</h1>
            <p style="color: #7f8c8d; font-size: 1rem;">Manage your food categories</p>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="button" class="btn btn-primary" @click="openAddModal">
                + Add Category
            </button>
        </div>

        <!-- View Category List -->
        <div class="mt-4">
            <div v-if="isLoading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading.......</span>
                </div>
            </div>
            <div v-else-if="!categories.length" class="text-center py-5 bg-light rounded">
                <p class="text-muted mb-0">No categories found. Create one to get started!</p>
            </div>
            <table v-else class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Foods Count</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(category, index) in categories" :key="category.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td><strong>{{ category.name }}</strong></td>
                        <td>{{ category.description }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ category.foods_count || 0 }}</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" @click="openEditModal(category)" title="Edit">
                                    ✏️
                                </button>
                                <button class="btn btn-sm btn-outline-danger" @click="deleteCategory(category.id)" title="Delete" :disabled="category.foods_count > 0">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Add/Edit Category -->
        <div ref="categoryModal" class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="categoryModalLabel">{{ isEditing ? 'Edit Category' : 'Add New Category' }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="submitCategory">
                        <div class="modal-body">
                            <div v-if="errorMessage" class="alert alert-danger" role="alert">
                                {{ errorMessage }}
                            </div>
                            <div v-if="successMessage" class="alert alert-success" role="alert">
                                {{ successMessage }}
                            </div>
                            <div class="mb-3">
                                <label for="category-name" class="col-form-label">Category Name:</label>
                                <input v-model.trim="form.name" type="text" class="form-control" id="category-name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="category-description" class="col-form-label">Description:</label>
                                <textarea v-model.trim="form.description" class="form-control" id="category-description"
                                    rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                                {{ isSubmitting ? "Saving..." : (isEditing ? "Update" : "Save Category") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';
import { Modal } from 'bootstrap';

const form = reactive({
    id: null,
    name: '',
    description: '',
});

const errorMessage = ref('');
const successMessage = ref('');
const isSubmitting = ref(false);
const isEditing = ref(false);
const categories = ref([]);
const isLoading = ref(false);
const categoryModal = ref(null);
const modalInstance = ref(null);

const fetchCategories = async () => {
    isLoading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data?.data || [];
    } catch (error) {
        errorMessage.value = error?.response?.data?.message || 'Failed to load categories.';
    } finally {
        isLoading.value = false;
    }
};

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.description = '';
    isEditing.value = false;
};

const openAddModal = () => {
    resetForm();
    if (categoryModal.value) {
        Modal.getOrCreateInstance(categoryModal.value).show();
    }
};

const openEditModal = (category) => {
    resetForm();
    isEditing.value = true;
    form.id = category.id;
    form.name = category.name;
    form.description = category.description;
    if (categoryModal.value) {
        Modal.getOrCreateInstance(categoryModal.value).show();
    }
};

const closeModal = () => {
    const modalEl = document.getElementById('categoryModal');
    if (!modalEl) return;

    const instance = Modal.getInstance(modalEl);
    if (instance) {
        instance.hide();
    }
    resetForm();
    // Safety cleanup in case the backdrop gets stuck.
    document.body.classList.remove('modal-open');
    document.querySelectorAll('.modal-backdrop').forEach((backdrop) => backdrop.remove());
};

const handleModalHidden = () => {
    if (!isSubmitting.value) {
        resetForm();
    }
};

const submitCategory = async () => {
    isSubmitting.value = true;
    errorMessage.value = '';
    successMessage.value = '';
    let isSuccess = false;

    try {
        if (isEditing.value) {
            await axios.put(`/api/categories/${form.id}`, {
                name: form.name,
                description: form.description,
            });
            successMessage.value = 'Category updated successfully.';
        } else {
            await axios.post('/api/categories', {
                name: form.name,
                description: form.description,
            });
            successMessage.value = 'Category saved successfully.';
        }
        
        resetForm();
        await fetchCategories();
        isSuccess = true;
        
    } catch (error) {
        errorMessage.value = error?.response?.data?.message || 'Failed to save category.';
    } finally {
        isSubmitting.value = false;
    }
    if (isSuccess) {
        closeModal();
        setTimeout(() => {
            successMessage.value = '';
            errorMessage.value = '';
        }, 300);
    }
};

const deleteCategory = async (id) => {
    if (!confirm('Are you sure you want to delete this category?')) return;
    
    try {
        await axios.delete(`/api/categories/${id}`);
        await fetchCategories();
    } catch (error) {
        alert(error?.response?.data?.message || 'Failed to delete category.');
    }
};

onMounted(() => {
    fetchCategories();
    if (categoryModal.value) {
        modalInstance.value = Modal.getOrCreateInstance(categoryModal.value);
        categoryModal.value.addEventListener('hidden.bs.modal', handleModalHidden);
    }
});

onBeforeUnmount(() => {
    if (categoryModal.value) {
        categoryModal.value.removeEventListener('hidden.bs.modal', handleModalHidden);
    }
    if (modalInstance.value) {
        modalInstance.value.dispose();
    }
});
</script>

<style scoped>
.container {
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0d5ce8 100%);
    border: none;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
}

.table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.table thead {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.badge {
    font-size: 0.8rem;
    padding: 0.4rem 0.6rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
}
</style>
