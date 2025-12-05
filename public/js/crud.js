// public/js/crud.js
document.addEventListener('alpine:init', () => {

    // Komponen CRUD generik
    Alpine.data('crud', function (config = {}) {
        return {
            config: {
                module: 'Item',
                route: '',
                items: [],
                fields: {},
                passwordField: false,
                ...config
            },

            showModal: false,
            isEdit: false,
            editId: null,
            form: {},
            confirmPassword: '',
            filteredItems: [],

            init() {
                // Salin semua data ke filteredItems saat pertama kali
                this.filteredItems = [...this.config.items];

                // Watch perubahan query dari global store, lalu update filteredItems
                this.$watch('$store.globalSearch.query', (value) => {
                    const keyword = (value || '').toLowerCase().trim();
                    if (!keyword) {
                        this.filteredItems = [...this.config.items];
                        return;
                    }

                    this.filteredItems = this.config.items.filter(item => {
                        return Object.values(item).some(val => {
                            if (val === null || val === undefined) return false;
                            return String(val).toLowerCase().includes(keyword);
                        });
                    });
                });

                this.resetForm();
            },

            formatDate(dateStr) {
                if (!dateStr) return '-';
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                }) + ' ' + date.toLocaleTimeString('id-ID', {
                    hour: '2-digit', minute: '2-digit'
                });
            },

            addItem() { this.isEdit = false; this.resetForm(); this.showModal = true; },
            editItem(item) {
                this.form = { ...item };
                this.editId = item.id;
                this.isEdit = true;
                this.confirmPassword = '';
                this.showModal = true;
            },

            async submitForm() {
                if (!this.isEdit && this.config.passwordField && this.form.password !== this.confirmPassword) {
                    Swal.fire('Error', 'Password dan konfirmasi tidak cocok!', 'error');
                    return;
                }

                const result = await Swal.fire({
                    title: this.isEdit ? 'Update Data?' : 'Simpan Data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                });
                if (!result.isConfirmed) return;

                const url = this.isEdit ? `${this.config.route}/${this.editId}` : this.config.route;
                const method = this.isEdit ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();
                    if (!response.ok) throw data;

                    Swal.fire('Success', data.message || 'Berhasil disimpan', 'success');

                    if (this.isEdit) {
                        const idx = this.config.items.findIndex(i => i.id === this.editId);
                        if (idx !== -1) {
                            this.config.items[idx] = data.user || data.data || data;
                        }
                    } else {
                        this.config.items.unshift(data.user || data.data || data);
                    }

                    // TAMBAHKAN BARIS INI — SUPAYA filteredItems IKUT UPDATE
                    this._refreshFilteredItems();

                    this.closeModal();
                } catch (err) {
                    const msg = err?.errors ? Object.values(err.errors)[0][0] : err?.message || 'Terjadi kesalahan';
                    Swal.fire('Gagal', msg, 'error');
                }
            },

            async deleteItem(id) {
                const res = await Swal.fire({
                    title: 'Yakin hapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                });
                if (!res.isConfirmed) return;

                try {
                    const response = await fetch(`${this.config.route}/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    });
                    const data = await response.json();
                    if (!response.ok) throw data;

                    this.config.items = this.config.items.filter(i => i.id !== id);
                    this._refreshFilteredItems();

                    Swal.fire('Deleted!', data.message || 'Data terhapus', 'success');
                } catch (err) {
                    Swal.fire('Error', err.message || 'Gagal menghapus', 'error');
                }
            },

            resetForm() {
                this.form = { ...this.config.fields };
                this.confirmPassword = '';
                this.editId = null;
                this.isEdit = false;
            },

            closeModal() {
                this.showModal = false;
                this.resetForm();
            },

            _refreshFilteredItems() {
                const keyword = (Alpine.store('globalSearch').query || '').toLowerCase().trim();
                if (!keyword) {
                    this.filteredItems = [...this.config.items];
                } else {
                    this.filteredItems = this.config.items.filter(item => {
                        return Object.values(item).some(val => {
                            if (val === null || val === undefined) return false;
                            return String(val).toLowerCase().includes(keyword);
                        });
                    });
                }
            },
        };
    });
});