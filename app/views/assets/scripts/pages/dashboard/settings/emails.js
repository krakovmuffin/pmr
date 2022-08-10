document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        _verified: ['required', 'equals:true'],
        SMTP_HOST: ['required', 'string'],
        SMTP_PORT: ['required', 'numeric'],
        SMTP_USER: ['required', 'email'],
        SMTP_PASS: ['required', 'string'],
        SMTP_FROM: ['optional', 'email'],
        SMTP_SECURITY: ['optional', 'string'],
        SMTP_ENABLED: ['required'],
      },

      _hasCustomValidation: true,
      _performValidation: (payload, schema) => {
        if (!Iodine) return false;

        if (payload.SMTP_ENABLED === 'false') return true;

        return Iodine.isValidSchema(payload, schema);
      },

      loadingTestEmail: false,

      init() {
        this.initForm(this);
      },

      async sendTestEmail() {
        if (this.loadingTestEmail) return;

        this.loadingTestEmail = true;

        this.error = null;
        this.success = null;

        const response = await api.fetch('/settings/emails/test', {
          method: 'POST',
          body: this.payload,
        });

        this.loadingTestEmail = false;

        if (response.failed) {
          this.error = response.content.error;
          return;
        }

        this.payload._verified = true;
        this.success = 'email';
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;

        const response = await api.fetch('/settings/emails', {
          method: 'POST',
          body: this.payload,
        });

        if (response.failed) {
          this.error = response.content.error;
          this.loading = false;
          return;
        }

        this.loading = false;
        this.success = 'save';
      },
    })
  );
});
