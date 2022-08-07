document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        name: ['required', 'string', 'minLength:3'],
        date_of_birth: ['required', 'string'],
        language: ['required', 'string'],
        email: ['required', 'email'],
        password: ['required', 'string', 'minLength: 6'],
      },

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        const response = await api.fetch('/sign-up', {
          method: 'POST',
          body: this.payload,
        });

        if (response.failed) {
          this.error = Object.keys(response.content.errors)[0];

          /* Potential extra feature : Jump to wrong step via this.$dispatch */

          this.loading = false;
          return;
        }

        this.redirect();
      },
    })
  );
});
