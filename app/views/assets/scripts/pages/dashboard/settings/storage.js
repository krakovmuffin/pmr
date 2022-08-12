document.addEventListener('alpine:init', () => {
  Alpine.data('form', () =>
    adriel.makeForm({
      _schema: {
        _verified: ['required', 'equals:true'],
        STORAGE_TYPE: ['required', 'string'],
        STORAGE_S3_HOST: ['required', 'string'],
        STORAGE_S3_BUCKET: ['required', 'string'],
        STORAGE_S3_REGION: ['required', 'string'],
        STORAGE_S3_KEY: ['required', 'string'],
        STORAGE_S3_SECRET: ['required', 'string'],
      },

      _hasCustomValidation: true,
      _performValidation: (payload, schema) => {
        if (!Iodine) return false;

        if (payload.STORAGE_TYPE === 'local') return true;

        return Iodine.isValidSchema(payload, schema);
      },

      loadingS3Test: false,

      init() {
        this.initForm(this);
      },

      async testS3Connection() {
        if (this.loading) return;
        if (this.loadingTest) return;

        this.loadingTest = true;

        this.error = null;
        this.success = null;

        const storageType = this.payload.STORAGE_TYPE;
        const response = await api.fetch(
          `/settings/storage/test/${storageType}`,
          {
            method: 'POST',
            body: this.payload,
          }
        );

        this.loadingTest = false;

        if (response.failed) {
          this.error = response.content.error;
          return;
        }

        this.payload._verified = true;
        this.success = 'test';
      },

      async submit() {
        if (this.loading) return;

        this.loading = true;
        this.error = null;
        this.success = null;

        const response = await api.fetch('/settings/storage', {
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
        this.payload._verified = false;
      },
    })
  );
});
