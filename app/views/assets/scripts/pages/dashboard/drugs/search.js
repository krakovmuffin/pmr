document.addEventListener('alpine:init', () => {
  Alpine.data('search', () => ({
    results: [],
    query: '',

    init() {},

    async autocomplete(event) {
      const { value } = event.target;

      if (value.length < 3) return;

      const query = encodeURIComponent(`brand_name:${value}`);
      const url = `https://api.fda.gov/drug/ndc.json?search=${query}&limit=6`;

      const response = await fetch(url).then((r) => r.json());

      if (!response.results) return;

      this.results = response.results.map((r) => ({
        name: r.brand_name,
        format: r.dosage_form,
        category: r.pharm_class,
      }));

      this.results = [
        ...new Map(
          this.results.map((v) => [JSON.stringify([v.name]), v])
        ).values(),
      ];
    },
  }));
});
