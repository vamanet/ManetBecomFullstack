<template>
  <AuthLayout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
      <div class="w-100" style="max-width: 420px;">
        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4">
          <!-- Header -->
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <div class="display-6 fw-bold text-primary mb-2">FullStack</div>
              <h2 class="h4 fw-bold text-dark">Create Account</h2>
              <p class="text-muted small">Join us today and get started</p>
            </div>

            <!-- Error Alert -->
            <div v-if="errors.general" class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-circle-fill me-2"></i>
              {{ errors.general }}
              <button type="button" class="btn-close" @click="errors.general = ''"></button>
            </div>

            <!-- Form -->
            <form @submit.prevent="register">
              <!-- Full Name -->
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Full Name</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-person text-primary"></i>
                  </span>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    class="form-control border-0 ps-0"
                    placeholder="John Doe"
                  />
                </div>
                <div v-if="errors.name" class="invalid-feedback d-block mt-1">
                  {{ errors.name[0] }}
                </div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-envelope text-primary"></i>
                  </span>
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    class="form-control border-0 ps-0"
                    placeholder="you@example.com"
                  />
                </div>
                <div v-if="errors.email" class="invalid-feedback d-block mt-1">
                  {{ errors.email[0] }}
                </div>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-lock text-primary"></i>
                  </span>
                  <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    class="form-control border-0 ps-0"
                    placeholder="••••••••"
                  />
                </div>
                <div v-if="errors.password" class="invalid-feedback d-block mt-1">
                  {{ errors.password[0] }}
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-lock-check text-primary"></i>
                  </span>
                  <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    class="form-control border-0 ps-0"
                    placeholder="••••••••"
                  />
                </div>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="loading"
                class="btn btn-primary w-100 fw-semibold py-2 rounded-3 mb-3"
              >
                <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                {{ loading ? 'Creating account...' : 'Sign Up' }}
              </button>

              <!-- Divider -->
              <div class="d-flex align-items-center my-4">
                <hr class="flex-grow-1" />
                <span class="px-3 text-muted small">or</span>
                <hr class="flex-grow-1" />
              </div>

              <!-- Sign In Link -->
              <p class="text-center text-muted mb-0">
                Already have an account?
                <router-link to="/login" class="fw-semibold text-decoration-none">
                  Sign in here
                </router-link>
              </p>
            </form>
          </div>
        </div>

        <!-- Footer Text -->
        <p class="text-center text-white-50 small mt-4">
          © 2026 FullStack. All rights reserved.
        </p>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import AuthLayout from '@/components/AuthLayout.vue'

const router = useRouter()
const loading = ref(false)

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const errors = reactive({
  general: '',
  name: [],
  email: [],
  password: [],
})

const register = async () => {
  loading.value = true
  Object.keys(errors).forEach(key => {
    errors[key] = []
  })

  try {
    const response = await fetch('/api/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
      body: JSON.stringify(form),
    })

    const data = await response.json()

    if (!response.ok) {
      if (data.errors) {
        Object.assign(errors, data.errors)
      } else {
        errors.general = data.message || 'Registration failed'
      }
      return
    }

    localStorage.setItem('auth_token', data.token)
    await router.push('/userdashboard')
  } catch (error) {
    errors.general = 'An error occurred. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
