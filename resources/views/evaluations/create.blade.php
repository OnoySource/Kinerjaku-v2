
@extends('layouts.app')

@section('title', 'Tambah Evaluasi | KinerjaKu')
@section('page-title', 'Evaluasi Kinerja')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    {{-- INTRO --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800">
            Tambah Nilai Karyawan
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Berikan penilaian berdasarkan indikator kinerja karyawan.
        </p>
    </div>

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="mb-1 font-bold">Periksa kembali data berikut:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($employees->isEmpty())
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            Belum ada karyawan aktif. Tambahkan atau aktifkan data karyawan terlebih dahulu.
        </div>
    @endif

    @if ($criteria->isEmpty())
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            Belum ada indikator penilaian aktif. Tambahkan kriteria terlebih dahulu.
        </div>
    @endif

    <form id="evaluationForm" action="{{ route('evaluations.store') }}" method="POST">
        @csrf

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- HEADER --}}
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="font-bold text-slate-800">
                    Formulir Penilaian
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Isi seluruh indikator dengan nilai 0 sampai 100.
                </p>
            </div>

            <div class="grid gap-8 p-6 lg:grid-cols-3">

                {{-- INPUT --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- KARYAWAN --}}
                    <div>
                        <label for="employee_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Pilih Karyawan
                        </label>

                        <select
                            name="employee_id"
                            id="employee_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >
                            <option value="">Pilih karyawan...</option>

                            @foreach ($employees as $employee)
                                <option
                                    value="{{ $employee->id }}"
                                    @selected(old('employee_id') == $employee->id)
                                >
                                    {{ $employee->employee_code }} - {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PERIODE --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="period_start" class="mb-2 block text-sm font-semibold text-slate-700">
                                Periode Mulai
                            </label>

                            <input
                                type="date"
                                name="period_start"
                                id="period_start"
                                value="{{ old('period_start') }}"
                                required
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            >
                        </div>

                        <div>
                            <label for="period_end" class="mb-2 block text-sm font-semibold text-slate-700">
                                Periode Selesai
                            </label>

                            <input
                                type="date"
                                name="period_end"
                                id="period_end"
                                value="{{ old('period_end') }}"
                                required
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            >
                        </div>
                    </div>

                    {{-- TANGGAL PENILAIAN --}}
                    <div>
                        <label for="evaluation_date" class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal Penilaian
                        </label>

                        <input
                            type="date"
                            name="evaluation_date"
                            id="evaluation_date"
                            value="{{ old('evaluation_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div class="border-t border-slate-100"></div>

                    {{-- KRITERIA DINAMIS --}}
                    <div>
                        <div class="mb-4">
                            <h3 class="font-bold text-slate-800">
                                Indikator Penilaian
                            </h3>

                            <p class="mt-1 text-xs text-slate-400">
                                Bobot mengikuti pengaturan kriteria di database.
                            </p>
                        </div>

                        <div class="space-y-6">
                            @foreach ($criteria as $criterion)
                                <div class="rounded-xl border border-slate-200 p-4">

                                    <div class="mb-3 flex flex-wrap items-start justify-between gap-2">
                                        <div>
                                            <label
                                                for="score_{{ $criterion->id }}"
                                                class="text-sm font-bold text-slate-700"
                                            >
                                                {{ $criterion->name }}
                                            </label>

                                            @if ($criterion->description)
                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $criterion->description }}
                                                </p>
                                            @endif
                                        </div>

                                        <span class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">
                                            Bobot {{ number_format((float) $criterion->weight, 2) }}%
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <input
                                            type="number"
                                            name="scores[{{ $criterion->id }}]"
                                            id="score_{{ $criterion->id }}"
                                            class="score-input w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                                            data-weight="{{ $criterion->weight }}"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ old('scores.' . $criterion->id, 0) }}"
                                            required
                                        >

                                        <span class="text-sm font-semibold text-slate-400">
                                            / 100
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <label
                                            for="details_notes_{{ $criterion->id }}"
                                            class="mb-1 block text-xs font-medium text-slate-500"
                                        >
                                            Catatan indikator (opsional)
                                        </label>

                                        <input
                                            type="text"
                                            name="details_notes[{{ $criterion->id }}]"
                                            id="details_notes_{{ $criterion->id }}"
                                            value="{{ old('details_notes.' . $criterion->id) }}"
                                            placeholder="Tambahkan catatan..."
                                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10"
                                        >
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- CATATAN UMUM --}}
                    <div>
                        <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">
                            Catatan Evaluasi
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            placeholder="Tulis catatan atau kesimpulan evaluasi..."
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        >{{ old('notes') }}</textarea>
                    </div>

                </div>

                {{-- HASIL --}}
                <div class="lg:border-l lg:border-slate-100 lg:pl-8">

                    <div class="rounded-2xl bg-slate-50 p-5">

                        <p class="text-sm font-semibold text-slate-500">
                            Hasil Nilai Akhir
                        </p>

                        <div class="mt-3 flex items-end gap-2">
                            <h2 id="finalScore" class="text-5xl font-extrabold tracking-tight text-blue-600">
                                0.00
                            </h2>

                            <span class="mb-1 text-sm text-slate-400">
                                / 100
                            </span>
                        </div>

                        <div class="mt-5 rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-semibold text-slate-400">
                                Predikat Kinerja
                            </p>

                            <p id="gradeResult" class="mt-2 text-lg font-bold text-slate-700">
                                Belum Dinilai
                            </p>

                            <p id="gradeDescription" class="mt-1 text-xs text-slate-400">
                                Masukkan nilai untuk melihat hasil.
                            </p>
                        </div>

                        {{-- RINGKASAN BOBOT --}}
                        <div class="mt-5 space-y-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Ringkasan Bobot
                            </p>

                            @foreach ($criteria as $criterion)
                                <div class="flex justify-between gap-3 text-sm">
                                    <span class="text-slate-500">
                                        {{ $criterion->name }}
                                    </span>

                                    <span class="font-semibold text-slate-700">
                                        {{ number_format((float) $criterion->weight, 2) }}%
                                    </span>
                                </div>
                            @endforeach

                            <div class="border-t border-slate-200 pt-3">
                                <div class="flex justify-between text-sm font-bold">
                                    <span>Total Bobot</span>

                                    <span class="text-blue-600">
                                        {{ number_format((float) $criteria->sum('weight'), 2) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="mt-5 space-y-3">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Kategori Penilaian
                        </p>

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">90 – 100</span>
                            <span class="font-semibold text-emerald-600">Sangat Baik</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">80 – 89</span>
                            <span class="font-semibold text-blue-600">Baik</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">70 – 79</span>
                            <span class="font-semibold text-amber-600">Cukup</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Di bawah 70</span>
                            <span class="font-semibold text-red-600">Perlu Evaluasi</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('evaluations.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <button
                    type="submit"
                    id="saveEvaluation"
                    @disabled($employees->isEmpty() || $criteria->isEmpty())
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Penilaian
                </button>

            </div>
        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('evaluationForm');
    const inputs = [...document.querySelectorAll('.score-input')];

    const finalScore = document.getElementById('finalScore');
    const gradeResult = document.getElementById('gradeResult');
    const gradeDescription = document.getElementById('gradeDescription');

    function calculateScore() {
        let weightedTotal = 0;
        let totalWeight = 0;
        let valid = true;

        inputs.forEach(input => {
            const rawValue = input.value.trim();
            const score = Number(rawValue);
            const weight = Number(input.dataset.weight);

            if (
                rawValue === '' ||
                !Number.isFinite(score) ||
                score < 0 ||
                score > 100 ||
                !Number.isFinite(weight) ||
                weight < 0
            ) {
                valid = false;
                return;
            }

            weightedTotal += score * weight;
            totalWeight += weight;
        });

        if (!valid || totalWeight <= 0) {
            finalScore.textContent = '--';
            gradeResult.textContent = 'Nilai Tidak Valid';
            gradeResult.className = 'mt-2 text-lg font-bold text-red-600';
            gradeDescription.textContent = 'Gunakan nilai antara 0 sampai 100.';
            return;
        }

        const result = weightedTotal / totalWeight;
        finalScore.textContent = result.toFixed(2);

        if (result >= 90) {
            gradeResult.textContent = 'Sangat Baik';
            gradeResult.className = 'mt-2 text-lg font-bold text-emerald-600';
            gradeDescription.textContent = 'Kinerja karyawan sangat memuaskan.';
        } else if (result >= 80) {
            gradeResult.textContent = 'Baik';
            gradeResult.className = 'mt-2 text-lg font-bold text-blue-600';
            gradeDescription.textContent = 'Kinerja karyawan sudah baik.';
        } else if (result >= 70) {
            gradeResult.textContent = 'Cukup';
            gradeResult.className = 'mt-2 text-lg font-bold text-amber-600';
            gradeDescription.textContent = 'Kinerja masih dapat ditingkatkan.';
        } else {
            gradeResult.textContent = 'Perlu Evaluasi';
            gradeResult.className = 'mt-2 text-lg font-bold text-red-600';
            gradeDescription.textContent = 'Kinerja perlu mendapatkan perhatian.';
        }
    }

    inputs.forEach(input => {
        input.addEventListener('input', calculateScore);
    });

    form.addEventListener('submit', function (event) {
        const employee = document.getElementById('employee_id');

        if (!employee.value) {
            event.preventDefault();
            alert('Silakan pilih karyawan terlebih dahulu.');
            employee.focus();
            return;
        }

        const start = document.getElementById('period_start').value;
        const end = document.getElementById('period_end').value;

        if (start && end && end < start) {
            event.preventDefault();
            alert('Tanggal akhir periode tidak boleh sebelum tanggal awal.');
            return;
        }

        const invalidInput = inputs.find(input => {
            const value = input.value.trim();
            const number = Number(value);

            return value === '' ||
                !Number.isFinite(number) ||
                number < 0 