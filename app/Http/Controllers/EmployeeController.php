<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // ==========================================
    // DAFTAR KARYAWAN
    // ==========================================

    public function index()
    {
        $employees = Employee::with('department')
            ->orderBy('name')
            ->get();

        return view('employees.index', compact('employees'));
    }

    // ==========================================
    // FORM TAMBAH KARYAWAN
    // ==========================================

    public function create()
    {
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('employees.create', compact('departments'));
    }

    // ==========================================
    // SIMPAN KARYAWAN
    // ==========================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'required|string|max:255',

            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:1000',
            'join_date' => 'required|date',

            'status' => 'required|in:active,inactive',
        ]);

        // Buat kode karyawan secara otomatis
        do {
            $employeeCode = 'EMP' . random_int(10000, 99999);
        } while (
            Employee::where('employee_code', $employeeCode)->exists()
        );

        $validated['employee_code'] = $employeeCode;

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    // ==========================================
    // DETAIL KARYAWAN
    // ==========================================

    public function show(string $id)
    {
        $employee = Employee::with([
            'department',
            'evaluations.details.criterion',
            'dailyOperations'
        ])->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    // ==========================================
    // FORM EDIT KARYAWAN
    // ==========================================

    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);

        $departments = Department::where('is_active', true)
            ->orWhere('id', $employee->department_id)
            ->orderBy('name')
            ->get();

        return view('employees.edit', compact(
            'employee',
            'departments'
        ));
    }

    // ==========================================
    // PERBARUI KARYAWAN
    // ==========================================

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'required|string|max:255',

            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:1000',
            'join_date' => 'required|date',

            'status' => 'required|in:active,inactive',
        ]);

        // employee_code tidak diubah saat edit
        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // ==========================================
    // HAPUS KARYAWAN
    // ==========================================

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
