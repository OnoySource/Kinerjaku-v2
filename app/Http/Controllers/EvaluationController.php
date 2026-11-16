<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Criterion;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EvaluationController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('name')->get();

        $criteria = Criterion::where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('evaluations.index', compact(
            'employees',
            'criteria'
        ));
    }

    public function store(Request $request)
    {
        $criteria = Criterion::where('is_active', true)
            ->orderBy('id')
            ->get();

        if ($criteria->isEmpty()) {
            throw ValidationException::withMessages([
                'employee_id' => 'Belum ada kriteria penilaian yang aktif.',
            ]);
        }

        // Validasi karyawan
        $rules = [
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],

            'scores' => [
                'required',
                'array',
            ],
        ];

        // Validasi setiap nilai berdasarkan ID kriteria
        foreach ($criteria as $criterion) {
            $rules['scores.' . $criterion->id] = [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ];
        }

        $validated = $request->validate($rules);

        // Pastikan total bobot adalah 100%
        $totalWeight = (float) $criteria->sum('weight');

        if (abs($totalWeight - 100) > 0.01) {
            throw ValidationException::withMessages([
                'employee_id' => 'Total bobot kriteria harus 100%. Saat ini total bobot adalah ' . $totalWeight . '%.',
            ]);
        }

        // Pastikan tidak ada nilai kriteria tambahan yang tidak dikenal
        $expectedIds = $criteria->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $submittedIds = array_map(
            'strval',
            array_keys($validated['scores'])
        );

        if (
            array_diff($expectedIds, $submittedIds) ||
            array_diff($submittedIds, $expectedIds)
        ) {
            throw ValidationException::withMessages([
                'employee_id' => 'Data kriteria penilaian tidak sesuai.',
            ]);
        }

        // Periode otomatis bulan berjalan
        $periodStart = now()->startOfMonth()->toDateString();
        $periodEnd = now()->endOfMonth()->toDateString();

        // Cek penilaian ganda
        $alreadyEvaluated = Evaluation::where(
            'employee_id',
            $validated['employee_id']
        )
            ->whereDate('period_start', $periodStart)
            ->whereDate('period_end', $periodEnd)
            ->exists();

        if ($alreadyEvaluated) {
            throw ValidationException::withMessages([
                'employee_id' => 'Karyawan ini sudah memiliki penilaian pada bulan ini.',
            ]);
        }

        // Hitung nilai akhir menggunakan bobot database
        $totalScore = 0;

        foreach ($criteria as $criterion) {
            $score = (float) $validated['scores'][$criterion->id];

            $totalScore += $score * ((float) $criterion->weight / 100);
        }

        // Simpan evaluasi dan detail dalam satu transaksi
        DB::transaction(function () use (
            $validated,
            $criteria,
            $periodStart,
            $periodEnd,
            $totalScore
        ) {
            $evaluation = Evaluation::create([
                'employee_id' => $validated['employee_id'],
                'evaluator_id' => auth()->id(),
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'evaluation_date' => now()->toDateString(),
                'total_score' => round($totalScore, 2),
            ]);

            foreach ($criteria as $criterion) {
                $evaluation->details()->create([
                    'criteria_id' => $criterion->id,
                    'score' => $validated['scores'][$criterion->id],
                ]);
            }
        });

        return redirect()
            ->route('evaluations.index')
            ->with('success', 'Penilaian karyawan berhasil disimpan.');
    }
}
