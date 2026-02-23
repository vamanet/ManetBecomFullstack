import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.user,
  },

  actions: {
    // Normalize API response
    setUser(response) {
      this.user = response?.data ?? null;
      // Save to localStorage for persistence
      if (this.user) {
        localStorage.setItem('user', JSON.stringify(this.user));
      } else {
        localStorage.removeItem('user');
      }
    },

    async fetchUser() {
      try {
        const res = await fetch('/api/user', {
          credentials: 'include',
          headers: { Accept: 'application/json' },
        });

        if (!res.ok) {
          // Only clear user on 401 (unauthorized)
          if (res.status === 401) {
            this.user = null;
            localStorage.removeItem('user');
          }
          throw new Error();
        }

        const data = await res.json();
        this.user = data.data;
        localStorage.setItem('user', JSON.stringify(this.user));
      } catch {
        // Keep user if fetch fails (network issue)
        // Only clear on 401 above
      }
    },

    async logout() {
      await fetch('/api/logout', {
        method: 'POST',
        credentials: 'include',
        headers: { Accept: 'application/json' },
      });

      this.user = null;
      localStorage.removeItem('user');
    },
  },
});