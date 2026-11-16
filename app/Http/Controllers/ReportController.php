<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $month = $validated['month'] ?? null;

        $query = Evaluation::with([
            'employee',
            'details.criterion',
        ]);

        // Filter berdasarkan bulan jika dipilih
        if ($month) {
            [$year, $selectedMonth] = explode('-', $month);

            $query->whereYear('period_start', $year)
                ->whereMonth('period_start', $selectedMonth);
        }

        // Statistik laporan
        $statsQuery = clone $query;

        $stats = [
            'total' => (clone $statsQuery)->count(),

            'average' => (clone $statsQuery)
                ->avg('total_score') ?? 0,

            'excellent' => (clone $statsQuery)
                ->where('total_score', '>=', 90)
                ->count(),

            'good' => (clone $statsQuery)
                ->whereBetween('total_score', [80, 89.99])
                ->count(),

            'fair' => (clone $statsQuery)
                ->whereBetween('total_score', [70, 79.99])
                ->count(),

            'poor' => (clone $statsQuery)
                ->where('total_score', '<', 70)
                ->count(),
        ];

        // Data laporan terbaru
        $evaluations = $query
            ->orderByDesc('evaluation_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact(
            'evaluations',
            'stats',
            'month'
        ));
    }
}
