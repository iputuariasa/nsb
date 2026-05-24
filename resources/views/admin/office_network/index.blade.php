@extends('admin.layouts.main')

@section('container')
<style>
    [x-cloak] { display: none !important; }
    .hierarchy-card { transition: all 0.3s ease; }
    .hierarchy-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
</style>

@push('scripts')
<script>
    window.pageData = {
        headOffices: @json($headOffices),
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('mainOrganizationCrud', () => ({
            config: {
                module: 'headOffice',
                route: '/headOffices',
                items: window.pageData.headOffices,
                fields: {
                    name: '',
                    code: '',
                    address: '',
                    phone: '',
                    email: ''
                },
                passwordField: false,
                dataKey: 'headOffice'
            },

            showModal: false,
            isEdit: false,
            editId: null,
            form: {},
            filteredItems: [],

            // Branch
            showBranchModal: false,
            isEditBranch: false,
            branchForm: { head_office_id: null, name: '', code: '', address: '', phone: '', email: '' },

            // Kiosk
            showKioskModal: false,
            isEditKiosk: false,
            kioskForm: { branch_id: null, name: '', code: '', address: '', phone: '', email: '' },

            init() {
                this.filteredItems = [...this.config.items];
                this.resetForm();
            },

            // ==================== HEAD OFFICE ====================
            addItem() {
                this.isEdit = false;
                this.resetForm();
                this.showModal = true;
            },

            editItem(item) {
                this.form = { ...item };
                this.editId = item.id;
                this.isEdit = true;
                this.showModal = true;
            },

            async submitForm() {
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
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            ...this.form,
                            _method: method
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        console.error('Server Error:', data); // ← Tambahan ini
                        throw new Error(data.message || JSON.stringify(data));
                    }

                    Swal.fire('Berhasil!', '', 'success');
                    location.reload();

                } catch (err) {
                    console.error(err);
                    Swal.fire('Gagal', err.message || 'Terjadi kesalahan server', 'error');
                }
            },

            async deleteItem(id) {
                const res = await Swal.fire({
                    title: 'Yakin hapus?',
                    text: 'Data ini dan semua cabang/kiosk di bawahnya akan ikut terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                });
                if (!res.isConfirmed) return;

                try {
                    await fetch(`/headOffices/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    Swal.fire('Terhapus!', '', 'success');
                    location.reload();
                } catch (e) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                }
            },

            // ==================== BRANCH ====================
            addBranch() {
                this.branchForm = { head_office_id: null, name: '', code: '', address: '', phone: '', email: '' };
                this.isEditBranch = false;
                this.showBranchModal = true;
            },

            editBranch(branch) {
                this.branchForm = { ...branch };
                this.isEditBranch = true;
                this.showBranchModal = true;
            },

            async submitBranchForm() {
                const url = this.isEditBranch ? `/branches/${this.branchForm.id}` : '/branches';
                const method = this.isEditBranch ? 'PUT' : 'POST';

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ...this.branchForm, _method: method })
                    });

                    if (res.ok) {
                        Swal.fire('Berhasil!', '', 'success');
                        location.reload();
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', e.message, 'error');
                }
            },

            async deleteBranch(id) {
                const res = await Swal.fire({
                    title: 'Yakin hapus cabang ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                });
                if (!res.isConfirmed) return;

                try {
                    await fetch(`/branches/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    });
                    Swal.fire('Terhapus!', '', 'success');
                    location.reload();
                } catch (e) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                }
            },

            // ==================== KIOSK ====================
            addKiosk() {
                this.kioskForm = { branch_id: null, name: '', code: '', address: '', phone: '', email: '' };
                this.isEditKiosk = false;
                this.showKioskModal = true;
            },

            editKiosk(kiosk) {
                this.kioskForm = { ...kiosk };
                this.isEditKiosk = true;
                this.showKioskModal = true;
            },

            async submitKioskForm() {
                const url = this.isEditKiosk ? `/kiosks/${this.kioskForm.id}` : '/kiosks';
                const method = this.isEditKiosk ? 'PUT' : 'POST';

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ...this.kioskForm, _method: method })
                    });

                    if (res.ok) {
                        Swal.fire('Berhasil!', '', 'success');
                        location.reload();
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', e.message, 'error');
                }
            },

            async deleteKiosk(id) {
                const res = await Swal.fire({
                    title: 'Yakin hapus kiosk ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus'
                });
                if (!res.isConfirmed) return;

                try {
                    await fetch(`/kiosks/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    });
                    Swal.fire('Terhapus!', '', 'success');
                    location.reload();
                } catch (e) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                }
            },

            resetForm() {
                this.form = { ...this.config.fields };
                this.editId = null;
                this.isEdit = false;
            },

            closeModal() {
                this.showModal = false;
                this.resetForm();
            }
        }));
    });
</script>
@endpush

<div x-data="mainOrganizationCrud()">
    <div class="w-full bg-white shadow-md rounded-md p-7">
        <div class="flex justify-between items-center">
            <span class="text-base font-bold text-slate-500">{{ $title }}</span>
            <div>
                <button
                    type="button"
                    @click="addItem()"
                    class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                    <span class="hidden md:inline-block">🏢 Tambah Pusat</span>
                </button>
                <button
                    type="button"
                    @click="addBranch()"
                    class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                    <span class="hidden md:inline-block">📍 Tambah Cabang</span>
                </button>
                <button
                    type="button"
                    @click="addKiosk()"
                    class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                    <span class="hidden md:inline-block">🛒 Tambah Kios</span>
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <template x-for="(headOffice, index) in filteredItems" :key="headOffice.id">
                <div class="hierarchy-card bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
                    
                    <!-- HEAD OFFICE -->
                    <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-xl">🏢</div>
                            <div>
                                <h2 class="font-bold text-lg" x-text="headOffice.name"></h2>
                                <div class="flex">
                                    <span class="text-sm text-slate-300">Kode : </span><span class="ms-2 me-5 text-sm text-slate-300" x-text="headOffice.code"></span>
                                    <div class="text-sm opacity-75">
                                        <span class="me-5">| </span><span x-text="headOffice.branches ? headOffice.branches.length : 0"></span> Cabang 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button @click="editItem(headOffice)" class="rounded-md bg-green-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 m-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button @click="deleteItem(headOffice.id)" class="rounded-md bg-red-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 mx-1">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- BRANCHES -->
                    <div class="p-6 bg-slate-50">
                        <template x-for="(branch, branchIndex) in headOffice.branches" :key="branch.id">
                            <div class="mb-4 last:mb-0 bg-white rounded-xl border border-slate-200 overflow-hidden">
                                
                                <!-- Branch Header -->
                                <div class="px-5 py-4 flex items-center justify-between bg-white hover:bg-slate-50 cursor-pointer"
                                    @click="branch.showKiosks = !branch.showKiosks">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">📍</div>
                                        <div>
                                            <h3 class="font-semibold text-slate-700" x-text="branch.name"></h3>
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm text-slate-500" x-text="branch.code"></p>
                                                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-0.5 rounded-full"
                                                    x-text="(branch.kiosks ? branch.kiosks.length : 0) + ' Kios'">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button @click="editBranch(branch)" class="text-xs bg-green-100 text-blue-700 px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button @click="deleteBranch(branch.id)" class="text-xs bg-red-100 text-blue-700 px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- KIOSKS (Accordion Content) -->
                                <div x-show="branch.showKiosks" class="border-t">
                                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <template x-for="(kiosk, kioskIndex) in branch.kiosks" :key="kiosk.id">
                                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 hover:border-slate-300 transition">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-lg mt-0.5">🛒</div>
                                                    <div class="flex-1">
                                                        <h4 class="font-medium text-slate-700" x-text="kiosk.name"></h4>
                                                        <p class="text-sm text-slate-500 line-clamp-2" x-text="kiosk.address"></p>
                                                        <div class="flex items-center gap-2">
                                                            <span class="mt-2 text-xs text-slate-400" x-text="kiosk.code"></span>
                                                            <div class="flex items-center gap-1">
                                                                <button @click="editKiosk(kiosk)" class="text-xs text-green-700 px-3">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </button>
                                                                <button @click="deleteKiosk(kiosk.id)" class="text-xs text-red-700 px-3">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Jika tidak ada branch -->
                        <div x-show="!headOffice.branches || headOffice.branches.length === 0" 
                            class="text-center py-12 text-slate-400">
                            Belum ada cabang untuk kantor pusat ini.
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- ==================== MODAL HEAD OFFICE (Diperbaiki) ==================== -->
        <div x-show="showModal" 
            x-cloak
            class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-black/60 overflow-y-auto">
            
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-slate-700 to-slate-800 text-white px-6 py-5">
                    <h2 class="text-xl font-bold" 
                        x-text="isEdit ? 'Edit Kantor Pusat' : 'Tambah Kantor Pusat Baru'">
                    </h2>
                </div>

                <div class="p-6">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pusat <span class="text-red-500">*</span></label>
                                <input x-model="form.name" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-transparent transition">
                            </div>

                            <!-- Kode -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pusat <span class="text-red-500">*</span></label>
                                <input x-model="form.code" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-transparent transition">
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea x-model="form.address" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-transparent transition" 
                                    rows="3"></textarea>
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input x-model="form.phone" type="text"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-transparent transition">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input x-model="form.email" type="email"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-transparent transition">
                            </div>

                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200 mt-6">
                            <button type="button" @click="closeModal()"
                                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-slate-700 to-slate-800 text-white rounded-xl hover:from-slate-800 hover:to-slate-900 transition font-semibold shadow-lg">
                                <span x-text="isEdit ? 'Update Pusat' : 'Simpan Pusat'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL BRANCH ==================== -->
        <div x-show="showBranchModal" 
            x-cloak
            class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-black/60 overflow-y-auto">
            
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-5">
                    <h2 class="text-xl font-bold" 
                        x-text="isEditBranch ? 'Edit Cabang' : 'Tambah Cabang Baru'">
                    </h2>
                </div>

                <div class="p-6">
                    <form @submit.prevent="submitBranchForm" class="space-y-6">
                        
                        <div class="space-y-5">
                            
                            <!-- Pilih Head Office -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kantor Pusat <span class="text-red-500">*</span></label>
                                <select x-model="branchForm.head_office_id" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Pilih Kantor Pusat --</option>
                                    <template x-for="ho in window.pageData.headOffices" :key="ho.id">
                                        <option :value="ho.id" x-text="ho.name"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Nama Cabang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Cabang <span class="text-red-500">*</span></label>
                                <input x-model="branchForm.name" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Kode Cabang -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Cabang <span class="text-red-500">*</span></label>
                                <input x-model="branchForm.code" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea x-model="branchForm.address" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <!-- Phone & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon</label>
                                    <input x-model="branchForm.phone" type="text"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input x-model="branchForm.email" type="email"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t">
                            <button type="button" @click="showBranchModal = false"
                                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold transition">
                                <span x-text="isEditBranch ? 'Update Cabang' : 'Simpan Cabang'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL KIOSK ==================== -->
        <div x-show="showKioskModal" 
            x-cloak
            class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-black/60 overflow-y-auto">
            
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-5">
                    <h2 class="text-xl font-bold" 
                        x-text="isEditKiosk ? 'Edit Kiosk' : 'Tambah Kiosk Baru'">
                    </h2>
                </div>

                <div class="p-6">
                    <form @submit.prevent="submitKioskForm" class="space-y-6">
                        
                        <div class="space-y-5">
                            
                            <!-- Pilih Branch -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Cabang <span class="text-red-500">*</span></label>
                                <select x-model="kioskForm.branch_id" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500">
                                    <option value="">-- Pilih Cabang --</option>
                                    <template x-for="ho in window.pageData.headOffices" :key="ho.id">
                                        <template x-for="branch in ho.branches" :key="branch.id">
                                            <option :value="branch.id" 
                                                    x-text="ho.name + ' - ' + branch.name"></option>
                                        </template>
                                    </template>
                                </select>
                            </div>

                            <!-- Nama Kiosk -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kiosk <span class="text-red-500">*</span></label>
                                <input x-model="kioskForm.name" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <!-- Kode Kiosk -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Kiosk <span class="text-red-500">*</span></label>
                                <input x-model="kioskForm.code" type="text" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea x-model="kioskForm.address" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500"></textarea>
                            </div>

                            <!-- Phone & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon</label>
                                    <input x-model="kioskForm.phone" type="text"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input x-model="kioskForm.email" type="email"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t">
                            <button type="button" @click="showKioskModal = false"
                                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-8 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-semibold transition">
                                <span x-text="isEditKiosk ? 'Update Kiosk' : 'Simpan Kiosk'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection