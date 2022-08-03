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

  // ACCOUNT API
  window.api.account = {
    // Update Avatar
    updateAvatar: async (avatar) => {
      const fd = new FormData();
      fd.append('avatar', avatar);

      const response = await _fetch('/account/avatar', {
        method: 'POST',
        isFile: true,
        body: fd,
      });

      if (response.failed) return false;

      return true;
    },

    // Erase avatar
    eraseAvatar: async () => {
      const response = await _fetch('/account/avatar', {
        method: 'DELETE',
      });

      if (response.failed) return false;

      return true;
    },

    // Update Personal Info
    updateInformation: async ({ fullname, email, phone }) => {
      const response = await _fetch('/account/information', {
        method: 'PUT',
        body: { fullname, email, phone },
      });

      if (response.failed) return false;

      return true;
    },

    // Update password
    updatePassword: async (password) => {
      const response = await _fetch('/account/password', {
        method: 'PUT',
        body: { password },
      });

      if (response.failed) return false;

      return true;
    },

    // Update business (customer info)
    updateBusiness: async ({
      company,
      siren,
      siret,
      vat_number,
      address_line,
      address_zip,
      address_city,
      address_country,
    }) => {
      const response = await _fetch(`/account/business`, {
        method: 'PUT',
        body: {
          company,
          siren,
          siret,
          vat_number,
          address_line,
          address_zip,
          address_city,
          address_country,
        },
      });

      if (response.failed) return false;

      return true;
    },
  };

  // USERS API
  window.api.users = {
    // Create
    create: async ({ fullname, email, power, password }) => {
      const response = await _fetch(`/users`, {
        method: 'POST',
        body: { fullname, email, power, password },
      });

      if (response.failed) return false;

      return true;
    },

    // Update Avatar
    updateAvatar: async (id, avatar) => {
      const fd = new FormData();
      fd.append('avatar', avatar);

      const response = await _fetch(`/users/${id}/avatar`, {
        method: 'POST',
        isFile: true,
        body: fd,
      });

      if (response.failed) return false;

      return true;
    },

    // Erase avatar
    eraseAvatar: async (id) => {
      const response = await _fetch(`/users/${id}/avatar`, {
        method: 'DELETE',
      });

      if (response.failed) return false;

      return true;
    },

    // Update Personal Info
    updateInformation: async (id, { fullname, email, power }) => {
      const response = await _fetch(`/users/${id}/information`, {
        method: 'PUT',
        body: { fullname, email, power },
      });

      if (response.failed) return false;

      return true;
    },

    // Update password
    updatePassword: async (id, password) => {
      const response = await _fetch(`/users/${id}/password`, {
        method: 'PUT',
        body: { password },
      });

      if (response.failed) return false;

      return true;
    },

    // Delete user
    delete: async (id) => {
      const response = await _fetch(`/users/${id}`, {
        method: 'DELETE',
      });

      if (response.failed) return false;

      return true;
    },
  };

  // CUSTOMERS API
  window.api.customers = {
    // Create
    create: async ({
      fullname,
      email,
      password,
      company,
      phone,
      siren,
      siret,
      vat_number,
      address_line,
      address_zip,
      address_city,
      address_country,
    }) => {
      const response = await _fetch(`/customers`, {
        method: 'POST',
        body: {
          fullname,
          email,
          password,
          company,
          phone,
          siren,
          siret,
          vat_number,
          address_line,
          address_zip,
          address_city,
          address_country,
        },
      });

      if (response.failed) return false;

      return true;
    },

    // Update
    update: async (
      id,
      {
        fullname,
        email,
        password,
        company,
        phone,
        siren,
        siret,
        vat_number,
        address_line,
        address_zip,
        address_city,
        address_country,
      }
    ) => {
      const response = await _fetch(`/customers/${id}`, {
        method: 'PUT',
        body: {
          fullname,
          email,
          password,
          company,
          phone,
          siren,
          siret,
          vat_number,
          address_line,
          address_zip,
          address_city,
          address_country,
        },
      });

      if (response.failed) return false;

      return true;
    },

    // Delete customer
    delete: async (id) => {
      const response = await _fetch(`/customers/${id}`, {
        method: 'DELETE',
      });

      if (response.failed) return false;

      return true;
    },

    // Create customer invoice
    createInvoice: async (id, { lead_count, lead_price }) => {
      const response = await _fetch(`/customers/${id}/invoices`, {
        method: 'POST',
        body: { lead_count, lead_price },
      });

      if (response.failed) return false;

      return true;
    },

    // Create customer model
    createModel: async (
      id,
      {
        name,
        quantity,
        schedule_type,
        scheduled_for,
        schedule_frequency,
        filters,
      }
    ) => {
      const response = await _fetch(`/customers/${id}/models`, {
        method: 'POST',
        body: {
          name,
          quantity,
          schedule_type,
          scheduled_for,
          schedule_frequency,
          filters,
        },
      });

      if (response.failed) return false;

      return true;
    },

    // Update customer model
    updateModel: async (
      customer_id,
      model_id,
      {
        name,
        quantity,
        schedule_type,
        scheduled_for,
        schedule_frequency,
        filters,
      }
    ) => {
      const response = await _fetch(
        `/customers/${customer_id}/models/${model_id}`,
        {
          method: 'PUT',
          body: {
            name,
            quantity,
            schedule_type,
            scheduled_for,
            schedule_frequency,
            filters,
          },
        }
      );

      if (response.failed) return false;

      return true;
    },

    // getModelEstimation: async
    getModelEstimation: async (id, filters) => {
      const response = await _fetch(`/customers/${id}/models/estimation`, {
        method: 'POST',
        body: {
          filters,
        },
      });

      if (response.failed) return 0;

      return response.content.count;
    },

    deleteModel: async (customerId, modelId) => {
      const response = await _fetch(
        `/customers/${customerId}/models/${modelId}`,
        {
          method: 'DELETE',
        }
      );

      if (response.failed) return false;

      return true;
    },

    executeModel: async (customerId, modelId) => {
      const response = await _fetch(
        `/customers/${customerId}/models/${modelId}/run`,
        {
          method: 'POST',
        }
      );

      if (response.failed) return false;

      return true;
    },
  };

  // LEADS API
  window.api.leads = {
    create: async ({ fullname, email, phone }) => {
      const response = await _fetch(`/leads`, {
        method: 'POST',
        body: { fullname, email, phone },
      });

      if (response.failed) return false;

      return true;
    },

    update: async (id, payload) => {
      const response = await _fetch(`/leads/${id}`, {
        method: 'PUT',
        body: payload,
      });

      if (response.failed) return false;

      return true;
    },

    delete: async (id) => {
      const response = await _fetch(`/leads/${id}`, {
        method: 'DELETE',
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
