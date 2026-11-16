<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where('status', 'active')->count();

        $totalDepartments = Department::count();

        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        $evaluations = Evaluation::with('employee.department')
            ->whereDate('period_start', $startDate)
            ->whereDate('period_end', $endDate)
            ->orderByDesc('total_score')
            ->get();

        $totalEvaluations = $evaluations->count();

        $averageScore = $totalEvaluations > 0
            ? round($evaluations->avg('total_score'), 2)
            : 0;

        $topEmployees = $evaluations->take(5);

        return view('dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'totalDepartments',
            'totalEvaluations',
            'averageScore',
            'topEmployees'
        ));
    }
}
