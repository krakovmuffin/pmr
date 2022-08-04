// Before Alpine init
window.adriel = {};
window.adriel.makeForm = (alpineForm) => {
  const defaultForm = {
    _instance: null,

    _schema: {},

    payload: {},

    ready: false,

    loading: false,

    success: null,

    error: null,

    initForm: (instance) => {
      this._instance = instance;

      // Setup payload as derived from the schema
      instance.payload = Object.keys(instance._schema).reduce(
        (a, b) => ({ ...a, [b]: '' }),
        {}
      );

      // Setup form validation
      instance.$watch('payload', () => {
        if (!Iodine) return false;
        instance.ready = Iodine.isValidSchema(
          instance.payload,
          instance._schema
        );
      });

      // Setup default values injected in DOM via value="xxx"
      [...instance.$el.querySelectorAll('input, select')].forEach((i) => {
        const name = i.getAttribute('name');
        const value = i.value;

        if (!value) return;

        instance.payload[name] = value;
      });
    },

    redirect: (instance) => {
      let url = instance.$el.dataset.redirect;
      // if (instance.$el.dataset.redirectWithId) url += '/' + instance._createdID;
      window.location = url;
    },
  };

  return { ...defaultForm, ...alpineForm };
};

// Still before Alpine init
(() => {
  // AJAX Definitions
  const url = '/a';

  // AJAX Fetch Helpers
  const _fetch = async (endpoint, params) => {
    const headers = params.headers || {};

    if (!params.isFile) headers['Content-Type'] = 'application/json';

    let response = await fetch(`${url}${endpoint}`, {
      ...params,
      headers,
      credentials: 'include',
      body: !params.isFile ? JSON.stringify(params.body) : params.body,
    }).then((r) => r.json());

    if (parseInt(response.code) > 300) response.failed = true;

    return response;
  };

  // AJAX API
  window.api = {};

  // AUTH API
  window.api.auth = {
    //Login
    login: async ({ email, password }) => {
      const response = await _fetch('/login/credentials', {
        method: 'POST',
        body: { email, password },
      });

      if (response.failed) return false;

      return response.content.user;
    },

    // Request a password reset code
    requestPasswordReset: async (email) => {
      await _fetch('/login/password-reset-requests', {
        method: 'POST',
        body: { email },
      });
    },

    // Authenticate a password reset code
    authenticatePasswordRequest: async (otp) => {
      const response = await _fetch('/login/password-reset-otp', {
        method: 'POST',
        body: { otp },
      });

      if (response.failed) return false;

      return true;
    },

    // Reset password
    resetPassword: async (password) => {
      const response = await _fetch('/login/password-reset', {
        method: 'POST',
        body: { password },
      });

      if (response.failed) return false;

      return true;
    },
  };
})();

window.addEventListener('load', () => {
  // [data-href] functioning
  (() => {
    const nodes = document.querySelectorAll('[data-href]');

    if (!nodes) return;

    for (let i = 0; i < nodes.length; i++) {
      nodes[i].addEventListener('click', () => {
        window.location = nodes[i].getAttribute('data-href');
      });
    }
  })();
});
