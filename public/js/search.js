document.addEventListener('alpine:init', () => {
    Alpine.store('globalSearch', {
        query: '',
        // optional: tambah debounce biar nggak lag saat ketik cepat
        set(value) {
            this.query = value;
        }
    });
});