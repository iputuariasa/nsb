document.addEventListener('alpine:init', () => {
    Alpine.data('crud', function (config = {}) {
        return {
            config: {
                module: 'Item',
                route: '',
                items: [],
                fields: {},
                passwordField: false,
                dataKey: 'data', // bisa diganti jadi 'user', 'branch', dll kalau perlu
                ...config
            },

            showModal: false,
            isEdit: false,
            editId: null,
            form: {},
            confirmPassword: '',
            filteredItems: [],

            init() {
                this.filteredItems = [...this.config.items];
                this.$watch('$store.globalSearch.query', () => this._refreshFilteredItems());
                this.resetForm();
            },

            addItem() {
                this.isEdit = false;
                this.resetForm();
                this.showModal = true;
            },

            editItem(item) {
                this.form = { ...item };
                this.editId = item.id;
                this.isEdit = true;
                this.confirmPassword = '';
                this.showModal = true;
            },

            async submitForm() {
                // Validasi password
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
                let method = this.isEdit ? 'PUT' : 'POST';

                // Spoofing untuk web routes (Laravel hanya terima POST)
                const actualMethod = method === 'PUT' ? 'POST' : method;

                try {
                    const response = await fetch(url, {
                        method: actualMethod,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            ...this.form,
                            _method: method === 'PUT' ? 'PUT' : undefined
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const msg = data.message || data.errors ? Object.values(data.errors)[0][0] : 'Terjadi kesalahan';
                        throw new Error(msg);
                    }

                    Swal.fire('Success!', data.message || 'Berhasil disimpan', 'success');

                    // Ambil data dari response (bisa 'branch', 'user', 'data', dll)
                    const returnedItem = data[this.config.dataKey] || data.data || data;

                    if (this.isEdit) {
                        const idx = this.config.items.findIndex(i => i.id === this.editId);
                        if (idx !== -1) this.config.items[idx] = returnedItem;
                    } else {
                        this.config.items.unshift(returnedItem);
                    }

                    this._refreshFilteredItems();
                    this.closeModal();

                } catch (err) {
                    Swal.fire('Gagal', err.message || 'Terjadi kesalahan', 'error');
                }
            },

            async deleteItem(id) {
                const res = await Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                });
                if (!res.isConfirmed) return;

                try {
                    const response = await fetch(`${this.config.route}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    let data = {};
                    const text = await response.text();
                    try {
                        data = text ? JSON.parse(text) : {};
                    } catch (e) {
                        data = { message: 'Data berhasil dihapus' };
                    }

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal menghapus');
                    }

                    this.config.items = this.config.items.filter(i => i.id !== id);
                    this._refreshFilteredItems();

                    Swal.fire('Terhapus!', data.message || 'Data berhasil dihapus', 'success');
                } catch (err) {
                    console.error('Delete error:', err);
                    Swal.fire('Error', err.message || 'Gagal menghapus data', 'error');
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
                    this.filteredItems = this.config.items.filter(item =>
                        Object.values(item).some(val =>
                            val !== null && val !== undefined && String(val).toLowerCase().includes(keyword)
                        )
                    );
                }
            },

            formatRupiah(angka, prefix = 'Rp ') {
                if (!angka && angka !== 0) return '-';
                
                // Konversi ke integer langsung
                const nilai = parseInt(angka, 10);
                if (isNaN(nilai)) return '-';

                return prefix + nilai.toLocaleString('id-ID');
            },
        };
    });
});