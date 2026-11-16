@extends('layouts.app')

@section('title', 'Tambah Karyawan | KinerjaKu')
@section('page-title', 'Tambah Karyawan')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Tambah Karyawan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Masukkan informasi karyawan baru.
            </p>
        </div>

        <a href="{{ route('employees.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- FORM -->
    <form action="{{ route('employees.store') }}" method="POST"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        @csrf

        <!-- FORM HEADER -->
        <div class="border-b border-slate-100 px-6 py-5">
            <h3 class="font-bold text-slate-800">
                Informasi Karyawan
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Lengkapi data sesuai informasi karyawan.
            </p>
        </div>

        <div class="space-y-6 p-6">

            <!-- ERROR VALIDATION -->
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="mb-2 text-sm font-semibold text-red-700">
                        Terdapat kesalahan pada formulir:
                    </p>

                    <ul class="list-inside list-disc space-y-1 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- INFO KODE OTOMATIS -->
            <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4">
                <i class="fa-solid fa-circle-info mt-0.5 text-blue-600"></i>

                <div>
                    <p class="text-sm font-semibold text-blue-800">
                        Kode Karyawan Otomatis
                    </p>

                    <p class="mt-1 text-sm text-blue-700">
                        Kode karyawan dengan awalan EMP akan dibuat
                        secara otomatis setelah data berhasil disimpan.
                    </p>
                </div>
            </div>

            <!-- DATA UTAMA -->
            <div>
                <h4 class="mb-4 text-sm font-bold text-blue-700">
                    <i class="fa-solid fa-user mr-2"></i>
                    Data Utama
                </h4>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <!-- NAME -->
                    <div>
                        <label for="name"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DEPARTMENT -->
                    <div>
                        <label for="department_id"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Departemen
                        </label>

                        <select id="department_id" name="department_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="">Pilih Departemen</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('department_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- POSITION -->
                    <div class="sm:col-span-2">
                        <label for="position"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Posisi / Jabatan <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="position"
                            name="position"
                            value="{{ old('position') }}"
                            placeholder="Contoh: Staff Administrasi"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('position')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            <!-- DATA PRIBADI -->
            <div>
                <h4 class="mb-4 text-sm font-bold text-blue-700">
                    <i class="fa-solid fa-address-card mr-2"></i>
                    Informasi Pribadi
                </h4>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <!-- GENDER -->
                    <div>
                        <label for="gender"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Jenis Kelamin
                        </label>

                        <select id="gender" name="gender"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="">Pilih Jenis Kelamin</option>

                            <option value="Laki-laki"
                                {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan"
                                {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>

                        @error('gender')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label for="phone"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor Telepon
                        </label>

                        <input type="text" id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ADDRESS -->
                    <div class="sm:col-span-2">
                        <label for="address"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Alamat
                        </label>

                        <textarea id="address" name="address" rows="3"
                            placeholder="Masukkan alamat lengkap"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('address') }}</textarea>

                        @error('address')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            <!-- DATA PEKERJAAN -->
            <div>
                <h4 class="mb-4 text-sm font-bold text-blue-700">
                    <i class="fa-solid fa-briefcase mr-2"></i>
                    Informasi Pekerjaan
                </h4>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <!-- JOIN DATE -->
                    <div>
                        <label for="join_date"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal Bergabung
                        </label>

                        <input type="date" id="join_date"
                            name="join_date"
                            value="{{ old('join_date') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('join_date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label for="status"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Status Karyawan <span class="text-red-500">*</span>
                        </label>

                        <select id="status" name="status" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="active"
                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="inactive"
                                {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

        </div>

        <!-- FORM FOOTER -->
        <div class="flex flex-col-reverse justify-end gap-3 border-t border-slate-100 bg-slate-50/50 px-6 py-5 sm:flex-row">

            <a href="{{ route('employees.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                Batal
            </a>

            <button type="submit"
                class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Simpan Karyawan
            </button>

        </div>

    </form>

</div>

@endsection
