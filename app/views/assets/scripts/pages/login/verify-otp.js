document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        otp: ['required', 'minLength:6', 'maxLength:6'],
      },

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        const response = await api.fetch('/verify-otp', {
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
