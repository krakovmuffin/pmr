document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        email: ['required', 'email'],
        password: ['required', 'minLength:6'],
      },

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        const response = await api.fetch('/sign-in', {
          method: 'POST',
          body: this.payload,
        });

        if (response.failed) {
          this.error = 'error';
          this.loading = false;
          return;
        }

        this.redirect();
      },
    })
  );
});
