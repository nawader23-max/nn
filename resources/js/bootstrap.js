// Nawader Bootstrap — Native fetch wrapper (no axios dependency)
const csrfToken = document.head.querySelector('meta[name="csrf-token"]')?.content || '';

window.nawaderFetch = (url, options = {}) => {
  return fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      ...options.headers,
    },
    ...options,
  });
};
