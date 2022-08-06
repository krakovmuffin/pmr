document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        password: ['required', 'minLength:6'],
      },

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        const response = await api.fetch('/reset-password', {
          method: 'POST',
          body: this.payload,
        });

        if (response.failed) {
          this.error = 'error';
          this.loading = false;
          return;
        }

        this.success = 'success';
        setTimeout(() => {
          this.redirect();
        }, 1000);
      },
    })
  );
});
