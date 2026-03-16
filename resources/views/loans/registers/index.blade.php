@extends('admin.layouts.main')

@section('container')
<style>[x-cloak]{display:none!important}</style>

@push('scripts')
<script>
    window.paginationInfo = {
        currentPage: {{ $loans->currentPage() }},
        perPage: {{ $loans->perPage() }}
    };

    window.pageData = {
        users: @json($users),
        branches: @json($branches),
        pillars: @json($pillars),
        loans: @json($loansCollection),
        ao: @json($ao),
        // tambah apa saja di sini, bebas!
    };

    window.crudConfig = {
        module: 'Loan',
        route: '/loans',
        items: window.pageData.loans,
        branches: window.pageData.branches,
        pillars: window.pageData.pillars,
        users: window.pageData.users,
        ao: window.pageData.ao,

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
            <div>
                <form action="{{ route('loans.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama, alamat, telp, dll..." 
                        class="w-full lg:w-96 pl-5 pr-5 py-1 text-sm rounded-lg border border-gray-300 bg-white text-gray-700 placeholder:text-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-lg hover:bg-blue-600">
                        Cari
                    </button>
                </form>
            </div>
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
                                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-black" x-text="(window.paginationInfo.currentPage - 1) * window.paginationInfo.perPage + index + 1">   
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
            <div class="mt-8 flex justify-center">
                {{ $loans->links('pagination::tailwind') }}
            </div>

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
            class="bg-white rounded-xl shadow-2xl w-full max-w-7xl my-8 mx-4 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold" x-text="isEdit ? 'Edit Kredit' : 'Tambah Kredit Baru'"></h2>
            </div>

            <div class="p-6 max-h-[80vh] overflow-y-auto">
                <form @submit.prevent="submitForm" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Sumber Data -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sumber Data</label>
                            <select x-model="form.pillar_id" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">-- Pilih Sumber Data --</option>
                                <template x-for="pillar in config.pillars" :key="pillar.id">
                                    <option :value="pillar.id" 
                                            x-text="`${pillar.name}`"></option>
                                </template>
                            </select>
                        </div>
                        
                        <!-- Nama Nasabah -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Nasabah</label>
                            <input x-model="form.customer_name" type="text" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- Nomer Telepon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomer Telepon</label>
                            <input x-model="form.phone_number" type="text" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        {{-- Alamat Nasabah --}}
                        <div class="">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                            <input x-model="form.address" type="text" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                    </div>

                    <hr class="h-[1px] w-full border-none bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-40">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Tanggal Permohonan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Permohonan</label>
                            <input x-model="form.application_date" type="date" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- Nominal Permohonan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal Permohonan</label>
                            <input x-model="form.requested_amount" type="number" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- Jangka Waktu -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jangka Waktu</label>
                            <input x-model="form.tenor_months" type="number" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Bulan">
                        </div>

                        <!-- Referensi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Referensi</label>
                            <select x-model="form.reference_id" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">-- Pilih Referensi --</option>
                                <template x-for="user in config.users" :key="user.id">
                                    <option :value="user.id" 
                                            x-text="`${user.name}`"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select x-model="form.status"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="Register">Register</option>
                                <option value="Proses">Proses</option>
                                <option value="Proposal">Proposal</option>
                                <option value="Persetujuan">Persetujuan</option>
                                <option value="Droping">Droping</option>
                                <option value="Tolak">Tolak</option>
                                <option value="Batal">Batal</option>
                                <option value="Tunda">Tunda</option>
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
