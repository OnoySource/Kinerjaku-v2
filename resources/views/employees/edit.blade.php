@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/80 ">
    <div class="w-full">

        {{-- HEADER ACTION --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('employees.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali
            </a>
        </div>


        {{-- VALIDATION --}}
        @if ($errors->any())
            <div class="mb-7 rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <p class="font-semibold text-sm text-red-700">
                            Data belum dapat disimpan
                        </p>
                        <ul class="mt-2 text-sm text-red-600 list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('employees.update', $employee->id) }}"
              method="POST">
            @csrf
            @method('PUT')

            {{-- INFORMASI PRIBADI --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-8 overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">
                            Informasi Pribadi
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Identitas dasar karyawan.
                        </p>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $employee->name) }}"
                               required
                               placeholder="Masukkan nama lengkap"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    {{-- JENIS KELAMIN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="gender"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $employee->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('gender', $employee->gender) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    {{-- TELEPON --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', $employee->phone) }}"
                               placeholder="Contoh: 08xxxxxxxxxx"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    {{-- ALAMAT --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address"
                                  rows="3"
                                  required
                                  placeholder="Masukkan alamat lengkap karyawan"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition resize-none">{{ old('address', $employee->address) }}</textarea>
                    </div>

                </div>
            </div>

            {{-- INFORMASI KEPEGAWAIAN --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-8 overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">
                            Informasi Kepegawaian
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Detail posisi dan status pekerjaan.
                        </p>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- KODE KARYAWAN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Kode Karyawan
                        </label>
                        <div class="relative">
                            <input type="text"
                                   value="{{ $employee->employee_code }}"
                                   readonly
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-sm font-semibold text-slate-500 cursor-not-allowed">
                            <i class="fas fa-lock absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">
                            Kode identitas tidak dapat diubah.
                        </p>
                    </div>

                    {{-- DEPARTEMEN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Departemen
                        </label>
                        <select name="department_id"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                            <option value="">Pilih departemen</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ (string) old('department_id', $employee->department_id) === (string) $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- JABATAN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jabatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="position"
                               value="{{ old('position', $employee->position) }}"
                               required
                               placeholder="Contoh: Staff Administrasi"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    {{-- TANGGAL BERGABUNG --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Bergabung <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="join_date"
                               value="{{ old('join_date', $employee->join_date ? \Illuminate\Support\Carbon::parse($employee->join_date)->format('Y-m-d') : '') }}"
                               required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                    </div>

                    {{-- STATUS --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Status Karyawan <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                required
                                class="w-full md:w-1/2 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition">
                            <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- ACTION BUTTON --}}
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:px-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">
                                Pastikan data sudah benar
                            </p>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                Perubahan akan disimpan ke dalam data karyawan.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row gap-3 sm:min-w-fit">

                        <a href="{{ route('employees.index') }}"
                           class="px-5 py-3 text-center rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white text-sm font-semibold shadow-lg shadow-blue-600/20 transition inline-flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>

                    </div>
                </div>
            </div>

        </form>

        <p class="text-center text-xs text-slate-400 mt-8">
            Employee Management System
        </p>

    </div>
</div>
@endsection
