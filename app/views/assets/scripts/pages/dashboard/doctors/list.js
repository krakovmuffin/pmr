document.addEventListener('alpine:init', () => {
  Alpine.data('search', () => ({
    search: '',
  }));
});
