@extends('admin.layouts.main')

@section('container')
<style>[x-cloak]{display:none!important}</style>

<div x-data="userForm()">
    <div class="w-full bg-white shadow-md rounded-md p-7">
        <div class="flex justify-between items-center">
            <span class="text-base font-bold text-slate-500">Data Pengguna</span>
            <button
                type="button"
                @click="addUser()"
                class="rounded-md bg-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 m-1">
                <i class="fa-solid fa-user-plus"></i><span class="ms-2 hidden md:inline-block">Tambah User</span>
            </button>
        </div>

        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="pt-5 overflow-x-auto">
                <table class="w-full border-collapse text-slate-600 mb-5">
                    <thead>
                    <tr class="bg-slate-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-b border-slate-300">Role</th>
                        <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider border-b border-slate-300">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template x-for="user, index in filteredUsers" :key="user.id">
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium">
                                    <div class="h-7 w-7 bg-green-600 text-white text-center flex justify-center items-center text-xl rounded font-black" x-text="index + 1"></div>
                                </td>
                                <td class="px-6 py-3 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium" x-text="user.email"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-semibold"><div x-text="user.name"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="user.position"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium"><div x-text="user.role"></div></td>
                                <td class="px-6 py-3 border-b border-slate-200 text-sm font-medium text-center">
                                    <button @click="editUser(user)" class="rounded-md bg-green-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 m-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button @click="deleteUser(user.id)" class="rounded-md bg-red-500 px-3 py-1 text-sm font-semibold text-white shadow-xs hover:bg-red-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 mx-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Modal -->
                <div
                    x-show="showModal"
                    x-cloak
                    @keydown.escape.window="closeModal"
                    class="fixed inset-0 z-99 flex items-center justify-center bg-black/50 p-4" >
                    <div
                        @click.outside=""
                        class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative" >
                        <h2 class="text-lg font-bold mb-4" x-text="isEdit ? 'Edit User' : 'Tambah User'"></h2>

                        <form @submit.prevent="submitForm" x-data="passwordMatch()">
                            @csrf
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-12">
                                <div class="sm:col-span-12">
                                    <label for="name" class="block text-sm/6 font-medium text-gray-900">Nama</label>
                                    <div class="mt-1">
                                        <input id="name" type="text" name="name" autocomplete="given-name" x-model="form.name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" x-model="form.name" />
                                    </div>
                                </div>
                                <div class="sm:col-span-12">
                                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                                    <div class="mt-1">
                                        <input id="email" type="text" name="email" autocomplete="given-name" x-model="form.email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" x-model="form.email" />
                                    </div>
                                </div>
                                <div class="sm:col-span-12">
                                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                                    <div class="mt-1">
                                        <input id="password" type="password" name="password" autocomplete="given-name" x-model="form.password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" x-model="form.password" />
                                    </div>
                                </div>
                                <!-- Konfirmasi Password -->
                                <div class="sm:col-span-12">
                                    <label for="confirmPassword" class="block text-sm/6 font-medium text-gray-900">Konfirmasi Password</label>
                                    <div class="mt-1">
                                        <input type="password" name="confirmPassword" id="confirmPassword" x-model="confirmPassword" required
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600">
                                    </div>
                                    <!-- Pesan error jika password tidak cocok -->
                                    <template x-if="confirmPassword && confirmPassword !== form.password">
                                        <p class="text-sm text-red-500 mt-1">Password tidak cocok</p>
                                    </template>
                                </div>
                                <div class="sm:col-span-12">
                                    <label for="position" class="block text-sm/6 font-medium text-gray-900">Jabatan</label>
                                    <div class="mt-1">
                                        <input id="position" type="text" name="position" autocomplete="given-name" x-model="form.position" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" x-model="form.position" />
                                    </div>
                                </div>
                                <div class="sm:col-span-12">
                                    <label for="role" class="block text-sm font-medium text-gray-900">Role</label>
                                    <select id="role" name="role" x-model="form.role"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 outline-gray-300">
                                        <option value="">-- Pilih Role --</option>
                                            <option value="admin">admin</option>
                                            <option value="reporter">reporter</option>
                                            <option value="credit">credit</option>
                                            <option value="ao">ao</option>
                                            <option value="fo">fo</option>
                                            <option value="ppk">ppk</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-12">
                                    <label for="hod" class="block text-sm font-medium text-gray-900">Kabid</label>
                                    <select id="hod" name="hod" x-model="form.hod"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-sm text-gray-900 outline-1 outline-gray-300">
                                        <option value="0">Tidak</option>
                                        <option value="1">Iya</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="closeModal" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                <button type="button" @click="submitForm()" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700" x-text="isEdit ? 'Update' : 'Simpan'"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function userForm() {
        return {
            showModal: false,
            form: 
            {
                name: '',
                email: '',
                password: '',
                position: '',
                role: '',
                hod: '0',
            },
            confirmPassword: '',
            users: @json($users),
            isEdit: false,
            editId: null,

            get filteredUsers() {
                const keyword = Alpine.store('userStore').search.toLowerCase();
                return this.users.filter(user =>
                    user.name.toLowerCase().includes(keyword) ||
                    user.email.toLowerCase().includes(keyword)
                );
            },

            formatDate(dateStr) {
                const date = new Date(dateStr);
                const tanggal = date.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
                const jam = date.toLocaleTimeString('id-ID', {
                    hour: '2-digit', minute: '2-digit', hour12: false
                });
                return `${tanggal} ${jam}`;
            },

            // buka modal tambah user
            addUser() {
                this.resetForm();
                this.isEdit = false;
                this.showModal = true;
            },

            submitForm() {
                if (this.form.password !== this.confirmPassword) {
                    Swal.fire('Oops', 'Password tidak cocok!', 'error');
                    return;
                }

                const url = this.isEdit
                    ? `/users/${this.editId}`
                    : '{{ route('users.store') }}';

                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                formData.append('position', this.form.position);
                formData.append('role', this.form.role);
                formData.append('hod', this.form.hod);
                if (this.isEdit) formData.append('_method', 'PATCH');

                fetch(url, {
                    method: 'POST', // selalu POST, update pakai _method=PATCH
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(data => {
                    if (this.isEdit) {
                        const index = this.users.findIndex(u => u.id === this.editId);
                        if (index !== -1) this.users[index] = data;
                        Swal.fire('Berhasil', 'Data berhasil diperbarui', 'success');
                    } else {
                        this.users.unshift(data);
                        Swal.fire('Berhasil', 'User berhasil ditambahkan', 'success');
                    }
                    this.closeModal();
                })
                .catch(async err => {
                    let message = 'Terjadi kesalahan';
                    if (err instanceof Response) {
                        try {
                            const error = await err.json();
                            message = error.message || message;
                        } catch {
                            message = err.statusText || message;
                        }
                    }
                    Swal.fire('Gagal', message, 'error');
                });
            },

            editUser(user) {
                this.form.name = user.name;
                this.form.email = user.email;
                this.form.password = '';
                this.form.position = user.position;
                this.form.role = user.role;
                this.form.hod = user.hod;
                this.confirmPassword = '';
                this.editId = user.id;
                this.isEdit = true;
                this.showModal = true;
            },


            // reset form
            resetForm() 
            {
                this.form = { name: '', email: '', password: '' };
                this.confirmPassword = '';
                this.editId = null;
                this.isEdit = false;
            },

            // tutup modal
            closeModal() {
                this.showModal = false;
                this.resetForm();
            },

            deleteUser(id) {
                Swal.fire({
                    title: 'Yakin hapus user ini?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/users/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw res;
                            this.users = this.users.filter(u => u.id !== id);
                            Swal.fire('Terhapus!', 'User berhasil dihapus.', 'success');
                        })
                        .catch(() => {
                            Swal.fire('Gagal', 'Tidak dapat menghapus user.', 'error');
                        });
                    }
                });
            }
        }
    }
</script>
@endsection
