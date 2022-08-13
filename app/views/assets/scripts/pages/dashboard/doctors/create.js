document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        name: ['required'],
        specialty: ['optional', 'string'],

        email: ['optional', 'email'],
        phone: ['optional', 'string'],

        address_line: ['optional', 'string'],
        address_city: ['optional', 'string'],
        address_zip: ['optional', 'string'],
        address_state: ['optional', 'string'],
        address_country: ['optional', 'string'],

        note: ['optional', 'string'],
      },

      canDisplayExtraFields: false,

      init() {
        this.initForm(this);
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;
        this.success = null;

        const response = await api.fetch('/doctors', {
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

        setTimeout(() => {
          this.redirect();
        }, 1000);
      },
    })
  );
});
