@extends('layouts.app')

@section('title', 'Laporan Kinerja | KinerjaKu')
@section('page-title', 'Laporan Kinerja')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Laporan Kinerja Karyawan
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Pantau dan evaluasi hasil penilaian kinerja seluruh karyawan.
        </p>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <!-- TOTAL PENILAIAN -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Penilaian
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $stats['total'] }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
            </div>
        </div>

        <!-- RATA-RATA -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Rata-rata Nilai
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ number_format($stats['average'], 2) }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>

        <!-- SANGAT BAIK -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Sangat Baik
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $stats['excellent'] }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-award text-xl"></i>
                </div>
            </div>
        </div>

        <!-- PERLU EVALUASI -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Perlu Evaluasi
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-red-600">
                        {{ $stats['poor'] }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- RINGKASAN PREDIKAT -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="font-bold text-slate-800">
            Ringkasan Predikat Kinerja
        </h3>

        <p class="mt-1 text-sm text-slate-400">
            Distribusi hasil penilaian karyawan.
        </p>

        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-4">

            <div class="rounded-xl bg-emerald-50 p-4">
                <p class="text-xs font-medium text-emerald-600">
                    Sangat Baik
                </p>

                <p class="mt-2 text-2xl font-bold text-emerald-700">
                    {{ $stats['excellent'] }}
                </p>
            </div>

            <div class="rounded-xl bg-blue-50 p-4">
                <p class="text-xs font-medium text-blue-600">
                    Baik
                </p>

                <p class="mt-2 text-2xl font-bold text-blue-700">
                    {{ $stats['good'] }}
                </p>
            </div>

            <div class="rounded-xl bg-amber-50 p-4">
                <p class="text-xs font-medium text-amber-600">
                    Cukup
                </p>

                <p class="mt-2 text-2xl font-bold text-amber-700">
                    {{ $stats['fair'] }}
                </p>
            </div>

            <div class="rounded-xl bg-red-50 p-4">
                <p class="text-xs font-medium text-red-600">
                    Perlu Evaluasi
                </p>

                <p class="mt-2 text-2xl font-bold text-red-700">
                    {{ $stats['poor'] }}
                </p>
            </div>

        </div>

    </div>

    <!-- DATA LAPORAN -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- HEADER DAN FILTER -->
        <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h3 class="font-bold text-slate-800">
                    Data Hasil Evaluasi
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Daftar hasil penilaian kinerja karyawan.
                </p>
            </div>

            <form action="{{ route('reports.index') }}" method="GET"
                class="flex flex-wrap items-center gap-2">

                <input
                    type="month"
                    name="month"
                    value="{{ $month }}"
                    class="rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="fa-solid fa-filter mr-1"></i>
                    Filter
                </button>

                @if ($month)
                    <a href="{{ route('reports.index') }}"
                        class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                @endif

            </form>

        </div>

        <!-- TABEL -->
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-4">No</th>
                        <th class="whitespace-nowrap px-6 py-4">Karyawan</th>
                        <th class="whitespace-nowrap px-6 py-4">Periode</th>
                        <th class="whitespace-nowrap px-6 py-4">Nilai Akhir</th>
                        <th class="whitespace-nowrap px-6 py-4">Predikat</th>
                        <th class="whitespace-nowrap px-6 py-4">Tanggal Penilaian</th>
                        <th class="whitespace-nowrap px-6 py-4 text-center">Detail</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($evaluations as $evaluation)

                        @php
                            $score = (float) $evaluation->total_score;

                            if ($score >= 90) {
                                $grade = 'Sangat Baik';
                                $badge = 'bg-emerald-50 text-emerald-700';
                            } elseif ($score >= 80) {
                                $grade = 'Baik';
                                $badge = 'bg-blue-50 text-blue-700';
                            } elseif ($score >= 70) {
                                $grade = 'Cukup';
                                $badge = 'bg-amber-50 text-amber-700';
                            } else {
                                $grade = 'Perlu Evaluasi';
                                $badge = 'bg-red-50 text-red-700';
                            }
                        @endphp

                        <tr class="transition hover:bg-slate-50">

                            <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                                {{ $evaluations->firstItem() + $loop->index }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $evaluation->employee->name ?? 'Karyawan tidak ditemukan' }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $evaluation->employee->employee_code ?? '-' }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($evaluation->period_start)->translatedFormat('M Y') }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="font-bold text-slate-800">
                                    {{ number_format($score, 2) }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-lg px-3 py-1.5 text-xs font-bold {{ $badge }}">
                                    {{ $grade }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                                {{ $evaluation->evaluation_date
                                    ? \Carbon\Carbon::parse($evaluation->evaluation_date)->translatedFormat('d M Y')
                                    : '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <button
                                    type="button"
                                    onclick="document.getElementById('detail-{{ $evaluation->id }}').classList.toggle('hidden')"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100"
                                    title="Lihat detail">

                                    <i class="fa-solid fa-eye"></i>

                                </button>
                            </td>

                        </tr>

                        <!-- DETAIL NILAI -->
                        <tr id="detail-{{ $evaluation->id }}" class="hidden bg-slate-50">

                            <td colspan="7" class="px-6 py-5">

                                <div class="rounded-xl border border-slate-200 bg-white p-5">

                                    <h4 class="mb-4 font-bold text-slate-800">
                                        Rincian Penilaian:
                                        {{ $evaluation->employee->name ?? '-' }}
                                    </h4>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                                        @foreach ($evaluation->details as $detail)

                                            <div class="rounded-xl bg-slate-50 p-4">

                                                <p class="text-xs text-slate-500">
                                                    {{ $detail->criterion->name ?? 'Kriteria' }}
                                                </p>

                                                <p class="mt-2 text-xl font-bold text-blue-600">
                                                    {{ number_format((float) $detail->score, 2) }}
                                                </p>

                                            </div>

                                        @endforeach

                                    </div>

                                    <div class="mt-4 border-t border-slate-100 pt-4 flex justify-between">
                                        <span class="text-sm font-semibold text-slate-500">
                                            Nilai Akhir
                                        </span>

                                        <span class="font-bold text-blue-600">
                                            {{ number_format($score, 2) }} / 100
                                        </span>
                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-14 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <i class="fa-solid fa-folder-open text-2xl"></i>
                                </div>

                                <h3 class="mt-4 font-bold text-slate-700">
                                    Belum Ada Data Laporan
                                </h3>

                                <p class="mt-1 text-sm text-slate-400">
                                    Belum ditemukan hasil evaluasi pada periode ini.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        @if ($evaluations->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $evaluations->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
