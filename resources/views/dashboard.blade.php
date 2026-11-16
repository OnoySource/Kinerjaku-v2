@extends('layouts.app')

@section('title', 'Dashboard | KinerjaKu')
@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-7">

    <!-- WELCOME -->
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-600 p-7 text-white shadow-sm sm:p-9">

        <div class="relative z-10 max-w-xl">

            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1.5 text-xs font-semibold">
                <i class="fa-solid fa-chart-line"></i>
                PERFORMANCE MANAGEMENT
            </span>

            <h1 class="mt-5 text-2xl font-extrabold sm:text-3xl">
                Selamat Datang di KinerjaKu
            </h1>

            <p class="mt-3 text-sm leading-relaxed text-blue-100 sm:text-base">
                Pantau, kelola, dan evaluasi kinerja seluruh karyawan
                dalam satu sistem informasi terintegrasi.
            </p>

        </div>

        <div class="pointer-events-none absolute -bottom-10 right-8 text-white/10">
            <i class="fa-solid fa-chart-column text-[180px]"></i>
        </div>

    </section>


    <!-- STATISTICS -->
    <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

        <!-- TOTAL EMPLOYEES -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Keseluruhan
                </span>

            </div>

            <p class="mt-5 text-sm text-slate-500">
                Total Karyawan
            </p>

            <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                {{ $totalEmployees }}
            </h3>

        </div>


        <!-- ACTIVE EMPLOYEES -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-user-check text-xl"></i>
                </div>

                <span class="text-xs font-medium text-emerald-600">
                    Aktif
                </span>

            </div>

            <p class="mt-5 text-sm text-slate-500">
                Karyawan Aktif
            </p>

            <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                {{ $activeEmployees }}
            </h3>

        </div>


        <!-- DEPARTMENTS -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i class="fa-solid fa-building text-xl"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Bidang
                </span>

            </div>

            <p class="mt-5 text-sm text-slate-500">
                Departemen
            </p>

            <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                {{ $totalDepartments }}
            </h3>

        </div>


        <!-- EVALUATION -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i class="fa-solid fa-clipboard-check text-xl"></i>
                </div>

                <span class="text-xs font-medium text-purple-600">
                    Evaluasi
                </span>

            </div>

            <p class="mt-5 text-sm text-slate-500">
                Penilaian Tersedia
            </p>

            <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                {{ $totalEvaluations }}
            </h3>

        </div>


        <!-- AVERAGE SCORE -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600">
                    <i class="fa-solid fa-star text-xl"></i>
                </div>

                <span class="text-xs font-medium text-cyan-600">
                    Bulan Ini
                </span>

            </div>

            <p class="mt-5 text-sm text-slate-500">
                Rata-rata Nilai Kinerja
            </p>

            <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                {{ number_format($averageScore, 2, ',', '.') }}
            </h3>

        </div>

    </section>

  
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-3">


        <!-- ACTIVITY -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm xl:col-span-2">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Ringkasan Aktivitas
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Informasi sistem KinerjaKu
                    </p>
                </div>

                <i class="fa-solid fa-chart-simple text-xl text-blue-600"></i>

            </div>


            <div class="mt-6 space-y-4">


                <!-- EMPLOYEE MANAGEMENT -->
                <div class="flex items-center gap-4 rounded-xl bg-slate-50 p-4">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-700">
                            Manajemen Karyawan
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Pengelolaan informasi seluruh karyawan.
                        </p>
                    </div>

                </div>


                <!-- EVALUATION -->
                <div class="flex items-center gap-4 rounded-xl bg-slate-50 p-4">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-700">
                            Evaluasi Kinerja
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Sistem penilaian dan pemantauan karyawan.
                        </p>
                    </div>

                </div>


                <!-- REPORT -->
                <div class="flex items-center gap-4 rounded-xl bg-slate-50 p-4">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-700">
                            Laporan Kinerja
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Ringkasan hasil penilaian karyawan.
                        </p>
                    </div>

                </div>

            </div>

        </div>


        <!-- QUICK INFORMATION -->
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

            <h3 class="font-bold text-slate-800">
                Informasi Sistem
            </h3>

            <p class="mt-1 text-xs text-slate-400">
                Status aplikasi
            </p>


            <div class="mt-6 space-y-5">

                <div>
                    <p class="text-xs text-slate-400">
                        Nama Aplikasi
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        KinerjaKu
                    </p>
                </div>


                <div>
                    <p class="text-xs text-slate-400">
                        Versi Sistem
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        1.0.0
                    </p>
                </div>


                <div>
                    <p class="text-xs text-slate-400">
                        Framework
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        Laravel 13
                    </p>
                </div>


                <div>
                    <p class="text-xs text-slate-400">
                        Status Sistem
                    </p>

                    <span class="mt-2 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                        Sistem Aktif

                    </span>
                </div>

            </div>

        </div>

    </section>

</div>

@endsection
