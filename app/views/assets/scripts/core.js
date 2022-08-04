/**
 * Runs before Alpine initializiation
 * -> Creates an `adriel` object attached to the `window` superglobal
 * -> Creates a method `adriel.makeForm` that helps working with forms and async within Alpine
 *
 * -> Creates an `api` object attached to the `window` superglobal
 */
(() => {
  window.adriel = {};

  window.adriel.makeForm = (alpineForm) => {
    const defaultForm = {
      /**
       * Set of rules to validate
       */
      _schema: {},

      /**
       * Data to send via POST / PUT, to be validated via _schema
       */
      payload: {},

      /**
       * Boolean to determine whether the form is submittable or not, based on _schema
       */
      ready: false,

      /**
       * Boolean to determine whether the form is loading or not, for UI aesthetic, and to prevent double submit
       */
      loading: false,

      /**
       * String determining what success message to show, often using "success" when there's only one message
       */
      success: null,

      /**
       * Same as `success` but for error
       */
      error: null,

      /**
       * Takes an instance of Alpine.data, and attaches variables and watchers to it
       */
      initForm: (instance) => {
        // Setup internal payload derived from the schema
        instance.payload = Object.keys(instance._schema).reduce(
          (a, b) => ({ ...a, [b]: '' }),
          {}
        );

        // Setup form validation when payload changes (using magic $watch)
        instance.$watch('payload', () => {
          if (!Iodine) return false;
          instance.ready = Iodine.isValidSchema(
            instance.payload,
            instance._schema
          );
        });

        // Setup default values injected in DOM via value="xxx"
        [...instance.$el.querySelectorAll('input, select, textarea')].forEach(
          (i) => {
            const name = i.getAttribute('name');
            const value = i.value;

            if (!value) return;

            instance.payload[name] = value;
          }
        );
      },

      /**
       * Simple redirect using the HTML attribute "data-redirect=URL"
       */
      redirect: (instance) => {
        let url = instance.$el.dataset.redirect;
        if (!url) return;
        window.location = url;
      },
    };

    return { ...defaultForm, ...alpineForm };
  };
})();

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

/**
 * Runs after Alpine initialization, when the page has fully loaded
 */
window.addEventListener('load', () => {
  /**
   * Make nodes with `data-href=URL` behave like <a href="URL"></a> tags
   */
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
