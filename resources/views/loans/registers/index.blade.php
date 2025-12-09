@extends('admin.layouts.main')

@section('container')
<style>[x-cloak]{display:none!important}</style>

@push('scripts')
<script>
    window.pageData = {
        users: @json($users),
        branches: @json($branches),
        pillars: @json($pillars),
        loans: @json($loans),
        // tambah apa saja di sini, bebas!
    };

    window.crudConfig = {
        module: 'User',
        route: '/users',
        items: window.pageData.loans,
        branches: window.pageData.branches,
        pillars: window.pageData.pillars,
        users: window.pageData.users,

        fields: {
            created_by: '',
            application_date: '',
            customer_name: '',
            address: '',
            phone_number: '',
            requested_amount: '',
            tenor_months: '',
            reference_id: '',
            pillar_id: '',
            ao_id: '',
            region_id: '',
            survey_number: '',
            disbursed_amount: '',
            principal_repayment: '0',
            net_disbursement: '',
            status: '',
            notes: ''
        },
        passwordField: false,
        dataKey: 'loan'
    };
</script>
@endpush

<div x-data="crud(window.crudConfig)">
    <div class="w-full bg-white shadow-md rounded-md p-7">
        <div class="flex justify-between items-center">
            <span class="text-base font-bold text-slate-500">Data Kredit</span>
            <button
                type="button"
                @click="addItem()"
                class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                <i class="fa-solid fa-user-plus"></i><span class="ms-2 hidden md:inline-block">Tambah Kredit</span>
            </button>
        </div>

        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="pt-5 overflow-x-auto">
                <table class="w-full border-collapse text-slate-600 mb-5">
                    <thead>
                    <tr class="bg-slate-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Tanggal Permohonan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">No.Telp</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Nominal Permohonan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Jangka Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Referensi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Sumber Data</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">AO</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Wilayah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">No.Survei</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Proposal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Droping</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Pelunasan Pokok</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Droping Bersih</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Keterangan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider border-b border-slate-300">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template x-for="(loan, index) in filteredItems" :key="loan.id">
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium">
                                    <div class="h-7 w-7 bg-green-600 text-white text-center flex justify-center items-center text-xl rounded font-black" x-text="index + 1"></div>
                                </td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-semibold"><div x-text="loan.application_date"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.customer_name"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.address"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.phone_number"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.requested_amount"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.tenor_months"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.reference?.name || '-'"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.pillar?.name || '-'"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.ao?.name || '-'"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.address"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.address"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.address"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="loan.address"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium text-center">
                                    <button @click="editItem(loan)" class="rounded-md bg-green-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 m-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button @click="deleteItem(loan.id)" class="rounded-md bg-red-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 mx-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- MODAL — LEBIH LEBAR & DI TENGAH -->
                <div x-show="showModal" 
                    x-cloak
                    class="fixed inset-0 z-99 flex items-center justify-center p-4 bg-black/50 overflow-y-auto">
                    
                    <div @click.outside="" 
                        class="bg-white rounded-xl shadow-2xl w-full max-w-4xl my-8 mx-4 overflow-hidden">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                            <h2 class="text-xl font-bold" x-text="isEdit ? 'Edit User' : 'Tambah User Baru'"></h2>
                        </div>

                        <div class="p-6 max-h-[80vh] overflow-y-auto">
                            <form @submit.prevent="submitForm" class="space-y-6">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    <!-- Nama -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input x-model="form.name" type="text" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                        <input x-model="form.email" type="email" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>

                                    <!-- PASSWORD BARU (Selalu muncul, tapi opsional saat edit) -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <span x-text="isEdit ? 'Password Baru (kosongkan jika tidak ingin ubah)' : 'Password'"></span>
                                        </label>
                                        <input x-model="form.password" type="password" 
                                            :required="!isEdit"
                                            placeholder=""
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>

                                    <!-- KONFIRMASI PASSWORD (hanya muncul kalau password diisi) -->
                                    <template x-if="form.password">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                            <div class="relative">
                                                <input x-model="confirmPassword" type="password" required
                                                    class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:border-transparent transition pr-12"
                                                    :class="{'border-red-500 focus:ring-red-500': confirmPassword && confirmPassword !== form.password,
                                                                'border-gray-300 focus:ring-blue-500': !confirmPassword || confirmPassword === form.password}">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <i x-show="confirmPassword && confirmPassword === form.password" 
                                                    class="fas fa-check text-green-500"></i>
                                                    <i x-show="confirmPassword && confirmPassword !== form.password" 
                                                    class="fas fa-times text-red-500"></i>
                                                </div>
                                            </div>
                                            <p x-show="confirmPassword && confirmPassword !== form.password" 
                                            class="text-red-500 text-xs mt-1">Password tidak cocok!</p>
                                        </div>
                                    </template>

                                    <!-- Jabatan -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                                        <input x-model="form.position" type="text" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>

                                    <!-- Cabang -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cabang</label>
                                        <select x-model="form.branch_id" 
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Cabang --</option>
                                            <template x-for="branch in config.branches" :key="branch.id">
                                                <option :value="branch.id" 
                                                        x-text="`${branch.branch_code} - ${branch.branch_name}`"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <!-- Role -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                                        <select x-model="form.role" required
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin">Admin</option>
                                            <option value="reporter">Reporter</option>
                                            <option value="credit">Credit</option>
                                            <option value="ao">AO</option>
                                            <option value="fo">FO</option>
                                            <option value="ppk">PPK</option>
                                        </select>
                                    </div>

                                    <!-- Kabid -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kabid</label>
                                        <select x-model="form.hod"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200 mt-6">
                                    <button type="button" @click="closeModal()"
                                            class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-medium">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-lg">
                                        <span x-text="isEdit ? 'Update User' : 'Simpan User'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
