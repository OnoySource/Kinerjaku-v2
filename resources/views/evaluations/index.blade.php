@extends('layouts.app')

@section('title', 'Evaluasi Kinerja | KinerjaKu')
@section('page-title', 'Evaluasi Kinerja')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    <!-- INTRO -->
    <div>
        <h2 class="text-xl font-bold text-slate-800">
            Tambah Nilai Karyawan
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Berikan penilaian berdasarkan indikator kinerja karyawan.
        </p>
    </div>

    <!-- NOTIFIKASI -->
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-700">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm text-red-700">
            <p class="font-semibold mb-2">Penilaian gagal disimpan:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <form action="{{ route('evaluations.store') }}" method="POST" id="evaluationForm">
        @csrf

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <!-- FORM HEADER -->
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="font-bold text-slate-800">
                    Formulir Penilaian
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Isi seluruh indikator dengan nilai 0 sampai 100.
                </p>
            </div>

            <div class="grid gap-8 p-6 lg:grid-cols-3">

                <!-- INPUT NILAI -->
                <div class="space-y-6 lg:col-span-2">

                    <!-- PILIH KARYAWAN -->
                    <div>
                        <label for="employee"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Pilih Karyawan
                        </label>

                        <select
                            id="employee"
                            name="employee_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">

                            <option value="">Pilih karyawan...</option>

                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="border-t border-slate-100"></div>

                    <!-- KRITERIA DINAMIS -->
                    @forelse ($criteria as $criterion)

                        <div>
                            <div class="mb-3 flex items-center justify-between">
                                <div>
                                    <label for="criterion_{{ $criterion->id }}"
                                        class="text-sm font-bold text-slate-700">
                                        {{ $criterion->name }}
                                    </label>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $criterion->description ?: 'Berikan penilaian sesuai indikator kinerja.' }}
                                    </p>
                                </div>

                                <span class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600 whitespace-nowrap">
                                    Bobot {{ number_format((float) $criterion->weight, 0) }}%
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <input
                                    type="number"
                                    id="criterion_{{ $criterion->id }}"
                                    name="scores[{{ $criterion->id }}]"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="{{ old('scores.' . $criterion->id, 0) }}"
                                    data-weight="{{ $criterion->weight }}"
                                    required
                                    class="score-input w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">

                                <span class="text-sm font-semibold text-slate-400">
                                    / 100
                                </span>
                            </div>

                            @error('scores.' . $criterion->id)
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    @empty

                        <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 text-sm text-amber-700">
                            Belum ada kriteria penilaian yang aktif.
                        </div>

                    @endforelse

                </div>

                <!-- HASIL PENILAIAN -->
                <div class="lg:border-l lg:border-slate-100 lg:pl-8">

                    <div class="rounded-2xl bg-slate-50 p-5">

                        <div class="mb-5">
                            <p class="text-sm font-semibold text-slate-500">
                                Hasil Nilai Akhir
                            </p>

                            <div class="mt-3 flex items-end gap-2">
                                <h2 id="finalScore"
                                    class="text-5xl font-extrabold tracking-tight text-blue-600">
                                    0.00
                                </h2>

                                <span class="mb-1 text-sm text-slate-400">
                                    / 100
                                </span>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-4">

                            <p class="text-xs font-semibold text-slate-400">
                                Predikat Kinerja
                            </p>

                            <p id="gradeResult"
                                class="mt-2 text-lg font-bold text-slate-700">
                                Belum Dinilai
                            </p>

                            <p id="gradeDescription"
                                class="mt-1 text-xs text-slate-400">
                                Masukkan nilai untuk melihat hasil.
                            </p>

                        </div>

                        <!-- RINGKASAN -->
                        <div class="mt-5 space-y-3">

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Ringkasan Bobot
                            </p>

                            @foreach ($criteria as $criterion)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500">
                                        {{ $criterion->name }}
                                    </span>

                                    <span class="font-semibold">
                                        {{ number_format((float) $criterion->weight, 0) }}%
                                    </span>
                                </div>
                            @endforeach

                            <div class="border-t border-slate-200 pt-3">
                                <div class="flex justify-between text-sm font-bold">
                                    <span>Total Bobot</span>

                                    <span class="text-blue-600">
                                        {{ number_format((float) $criteria->sum('weight'), 0) }}%
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- KETERANGAN -->
                    <div class="mt-5 space-y-3">

                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Kategori Penilaian
                        </p>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">90 – 100</span>
                            <span class="font-semibold text-emerald-600">Sangat Baik</span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">80 – 89</span>
                            <span class="font-semibold text-blue-600">Baik</span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">70 – 79</span>
                            <span class="font-semibold text-amber-600">Cukup</span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Di bawah 70</span>
                            <span class="font-semibold text-red-600">Perlu Evaluasi</span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- FORM FOOTER -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-slate-400">
                    Pastikan semua nilai sudah sesuai sebelum disimpan.
                </p>

                <button
                    type="submit"
                    id="saveEvaluation"
                    {{ $criteria->isEmpty() ? 'disabled' : '' }}
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Penilaian

                </button>

            </div>

        </div>
    </form>

</div>

<!-- CALCULATION SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const inputs = document.querySelectorAll('.score-input');

    const finalScore = document.getElementById('finalScore');
    const gradeResult = document.getElementById('gradeResult');
    const gradeDescription = document.getElementById('gradeDescription');

    function calculateScore() {

        let total = 0;
        let valid = true;

        inputs.forEach(input => {

            const value = input.value.trim();
            const score = Number(value);
            const weight = Number(input.dataset.weight);

            if (
                value === '' ||
                !Number.isFinite(score) ||
                score < 0 ||
                score > 100
            ) {
                valid = false;
                return;
            }

            total += score * weight / 100;

        });

        if (!valid) {
            finalScore.textContent = '--';
            gradeResult.textContent = 'Nilai Tidak Valid';
            gradeDescription.textContent = 'Gunakan nilai antara 0 sampai 100.';
            return;
        }

        finalScore.textContent = total.toFixed(2);

        if (total >= 90) {
            gradeResult.textContent = 'Sangat Baik';
            gradeResult.className = 'mt-2 text-lg font-bold text-emerald-600';
            gradeDescription.textContent = 'Kinerja karyawan sangat memuaskan.';

        } else if (total >= 80) {
            gradeResult.textContent = 'Baik';
            gradeResult.className = 'mt-2 text-lg font-bold text-blue-600';
            gradeDescription.textContent = 'Kinerja karyawan sudah baik.';

        } else if (total >= 70) {
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

    calculateScore();

});
</script>

@endsection
