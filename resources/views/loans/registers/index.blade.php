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
            proposal: '',
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

<div x-data="crud(window.crudConfig)" class="h-[87vh] flex flex-col bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Header + Tombol Tambah -->
    <div class="w-full bg-white shadow-md rounded-md p-7">
        <div class="flex justify-between items-center">
            <h1 class="text-base font-bold text-slate-500">{{$title}}</h1>
            <button
                type="button"
                @click="addItem()"
                class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                <i class="fa-solid fa-user-plus"></i><span class="ms-2 hidden md:inline-block">Tambah {{ $title }}</span>
            </button>
        </div>
    </div>

    <!-- Tabel dengan Fixed Header + Fixed Kolom Kiri -->
    <div class="flex-1 overflow-hidden relative">
        <div class="overflow-auto h-full">
            <table class="w-full min-w-max table-auto text-sm text-left border-collapse text-slate-600 mb-5">
                <!-- HEADER FIXED -->
                <thead class="sticky top-0 z-20 shadow-md bg-slate-100 text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center font-bold uppercase tracking-wider sticky w-16 left-0 z-30 bg-slate-100">No</th>
                        <th class="px-6 py-4 text-center font-bold uppercase tracking-wider w-32 sticky left-16 z-30 bg-slate-100">Aksi</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Tgl Pengajuan</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Nama Nasabah</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">No. Telp</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Nominal</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-center">Tenor</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Referensi</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Sumber</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">AO</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Wilayah</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">No Survey</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Proposal</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Droping</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Pelunasan Pokok</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-right">Droping Bersih</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="(loan, index) in filteredItems" :key="loan.id">
                        <tr class="hover:bg-gray-50 transition">
                            <!-- NO — FIXED KIRI -->
                            <td class="px-6 py-4 text-center font-bold bg-white sticky left-0 z-10">
                                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-black" x-text="index + 1">   
                                </div>
                            </td>
                            <!-- AKSI — FIXED KIRI -->
                            <td class="px-6 py-4 text-center whitespace-nowrap border-r border-gray-300 bg-white sticky left-16 z-10">
                                <button @click="editItem(loan)" class="text-green-600 hover:text-green-800 mr-3">
                                    <i class="fas fa-edit text-lg"></i>
                                </button>
                                <button @click="deleteItem(loan.id)" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </td>
                            <!-- Kolom lainnya (bisa di-scroll horizontal) -->
                            <td class="px-6 py-4 whitespace-nowrap" x-text="loan.application_date"></td>
                            <td class="px-6 py-4 font-semibold" x-text="loan.customer_name"></td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="line-clamp-2" x-text="loan.address || '-'"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" x-text="loan.phone_number"></td>
                            <td class="px-6 py-4 text-right font-bold text-green-700" x-text="formatRupiah(loan.requested_amount)"></td>
                            <td class="px-6 py-4 text-center" x-text="loan.tenor_months + ' bln'"></td>
                            <td class="px-6 py-4" x-text="loan.reference?.name || '-'"></td>
                            <td class="px-6 py-4" x-text="loan.pillar?.name || '-'"></td>
                            <td class="px-6 py-4" x-text="loan.ao?.name || '-'"></td>
                            <td class="px-6 py-4" x-text="loan.region?.branch_name || '-'"></td>
                            <td class="px-6 py-4 whitespace-nowrap" x-text="loan.survey_number || '-'"></td>
                            <td class="px-6 py-4 text-right" x-text="formatRupiah(loan.proposal)"></td>
                            <td class="px-6 py-4 text-right" x-text="formatRupiah(loan.disbursed_amount)"></td>
                            <td class="px-6 py-4 text-right" x-text="formatRupiah(loan.principal_repayment)"></td>
                            <td class="px-6 py-4 text-right font-bold text-blue-700" x-text="formatRupiah(loan.net_disbursement)"></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold"
                                      :class="{
                                          'bg-blue-100 text-blue-800': loan.status === 'Register',
                                          'bg-yellow-100 text-yellow-800': loan.status === 'Proses',
                                          'bg-indigo-100 text-indigo-800': loan.status === 'Proposal',
                                          'bg-cyan-100 text-cyan-800': loan.status === 'Persetujuan',
                                          'bg-orange-100 text-orange-800': loan.status === 'Tunda',
                                          'bg-green-100 text-green-800': loan.status === 'Droping',
                                          'bg-red-100 text-red-800': loan.status === 'Tolak',
                                          'bg-gray-100 text-gray-800': loan.status === 'Batal'
                                      }"
                                      x-text="loan.status"></span>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <div class="line-clamp-3" x-text="loan.notes || '-'"></div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Empty State -->
            <div x-show="filteredItems.length === 0" class="text-center py-20 text-gray-500">
                <i class="fas fa-inbox text-6xl mb-4"></i>
                <p class="text-xl font-medium">Belum ada data kredit</p>
            </div>
        </div>
    </div>

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
@endsection
