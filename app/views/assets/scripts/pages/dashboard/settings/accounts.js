document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        ACCOUNT_REGISTRATION_ENABLED: ['required'],
        ACCOUNT_PASSWORD_RESET_ENABLED: ['required'],
      },

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;
        this.success = null;

        const response = await api.fetch('/settings/accounts', {
          method: 'POST',
          body: this.payload,
        });

        if (response.failed) {
          this.error = 'error';
          this.loading = false;
          return;
        }

        this.loading = false;
        this.success = 'success';
      },
    })
  );
});
