import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.user,
  },

  actions: {
    // Normalize API response
    setUser(response) {
      this.user = response?.data ?? null;
    },

    async fetchUser() {
      try {
        const res = await fetch('/api/user', {
          credentials: 'include',
          headers: { Accept: 'application/json' },
        });

        if (!res.ok) throw new Error();

        const data = await res.json();
        this.user = data.data;
      } catch {
        this.user = null;
      }
    },

    async logout() {
      await fetch('/api/logout', {
        method: 'POST',
        credentials: 'include',
        headers: { Accept: 'application/json' },
      });

      this.user = null;
    },
  },
});