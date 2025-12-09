@extends('admin.layouts.main')

@section('container')
<style>[x-cloak]{display:none!important}</style>

@push('scripts')
<script>
    window.pageData = {
        pillars: @json($pillars),
    };

    window.crudConfig = {
        module: 'Pillar',
        route: '/pillars',
        items: window.pageData.pillars,
        fields: {
            name: '',
        },
        passwordField: false,
        dataKey: 'pillar'
    };
</script>
@endpush

<div x-data="crud(window.crudConfig)">
    <div class="w-full bg-white shadow-md rounded-md p-7">
        <div class="flex justify-between items-center">
            <span class="text-base font-bold text-slate-500">{{ $title }}</span>
            <button
                type="button"
                @click="addItem()"
                class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                <i class="fa-solid fa-user-plus"></i><span class="ms-2 hidden md:inline-block">Tambah {{ $title }}</span>
            </button>
        </div>

        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="pt-5 overflow-x-auto">
                <table class="w-full border-collapse text-slate-600 mb-5">
                    <thead>
                    <tr class="bg-slate-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Nama Pilar</th>
                        <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider border-b border-slate-300">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template x-for="(pillar, index) in filteredItems" :key="pillar.id">
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium">
                                    <div class="h-7 w-7 bg-green-600 text-white text-center flex justify-center items-center text-xl rounded font-black" x-text="index + 1"></div>
                                </td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-semibold"><div x-text="pillar.name"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium text-center">
                                    <button @click="editItem(pillar)" class="rounded-md bg-green-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 m-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button @click="deleteItem(pillar.id)" class="rounded-md bg-red-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 mx-1">
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
                            <h2 class="text-xl font-bold" x-text="isEdit ? 'Edit Pilar' : 'Tambah Pilar Baru'"></h2>
                        </div>

                        <div class="p-6 max-h-[80vh] overflow-y-auto">
                            <form @submit.prevent="submitForm" class="space-y-6">
                                
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                                    
                                    <!-- Nama Pilar -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pilar</label>
                                        <input x-model="form.name" type="text" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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
                                        <span x-text="isEdit ? 'Update Pilar' : 'Simpan Pilar'"></span>
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
