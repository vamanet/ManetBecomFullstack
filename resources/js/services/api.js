export async function csrf() {
  await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
}

export async function apiRequest(url, options = {}) {
  await csrf();

  const response = await fetch(url, {
    credentials: 'include',
    ...options,
  });

  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.message || 'API Error');
  }

  return response.json();
}