@extends('layouts.app')

@section('title', 'Data Karyawan | KinerjaKu')
@section('page-title', 'Data Karyawan')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex justify-end">

        <a href="{{ route('employees.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Karyawan

        </a>

    </div>


    <!-- EMPLOYEE TABLE -->
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- TABLE HEADER -->
        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

            <h3 class="text-base font-bold text-slate-800">
                Daftar Karyawan
            </h3>

        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[650px] text-left">

                <thead class="bg-slate-50">

                    <tr class="border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($employees as $employee)

                        <tr class="transition hover:bg-slate-50/70">

                            <!-- NAME -->
                            <td class="px-6 py-5">

                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $employee->name }}
                                </p>

                            </td>


                            <!-- DEPARTMENT -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-600">
                                    {{ $employee->department->name ?? '-' }}
                                </span>

                            </td>


                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                @if ($employee->status === 'active')

                                    <span class="inline-flex rounded-md bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex rounded-md bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>


                            <!-- ACTIONS -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    <!-- VIEW -->
                                    <button type="button"
                                        class="view-employee flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"

                                        data-name="{{ $employee->name }}"
                                        data-department="{{ $employee->department->name ?? '-' }}"
                                        data-status="{{ $employee->status === 'active' ? 'Aktif' : 'Nonaktif' }}"
                                        data-id="{{ $employee->id }}"

                                        data-gender="{{ $employee->gender ?? '-' }}"
                                        data-position="{{ $employee->position ?? '-' }}"
                                        data-address="{{ $employee->address ?? '-' }}"
                                        data-join-date="{{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d-m-Y') : '-' }}"

                                        title="Lihat Detail"
                                        aria-label="Lihat detail {{ $employee->name }}">

                                        <i class="fa-regular fa-eye"></i>

                                    </button>


                                    <!-- EDIT -->
                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                        title="Edit Karyawan"
                                        aria-label="Edit {{ $employee->name }}"

                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600">

                                        <i class="fa-regular fa-pen-to-square"></i>

                                    </a>


                                    <!-- DELETE -->
                                    <form action="{{ route('employees.destroy', $employee->id) }}"
                                        method="POST"
                                        class="delete-employee-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="delete-employee flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"

                                            data-name="{{ $employee->name }}"

                                            title="Hapus Karyawan"
                                            aria-label="Hapus {{ $employee->name }}">

                                            <i class="fa-regular fa-trash-can"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-12 text-center">

                                <p class="text-sm font-semibold text-slate-700">
                                    Belum Ada Data Karyawan
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Belum ada karyawan yang terdaftar.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>


<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* ==========================================
   LIHAT DETAIL KARYAWAN
========================================== */

document.addEventListener('click', function(e) {

    const button = e.target.closest('.view-employee');

    if (!button) return;

    const name = button.dataset.name;
    const department = button.dataset.department;
    const status = button.dataset.status;
    const id = button.dataset.id;

    const gender = button.dataset.gender;
    const position = button.dataset.position;
    const address = button.dataset.address;
    const joinDate = button.dataset.joinDate;

    Swal.fire({

        title: 'Detail Karyawan',

        html: `
            <div style="text-align:left;padding:10px 5px;">

                <div style="text-align:center;margin-bottom:24px;">

                    <div style="
                        width:68px;
                        height:68px;
                        border-radius:18px;
                        background:#dbeafe;
                        color:#2563eb;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:26px;
                        font-weight:bold;
                        margin:auto;">

                        ${escapeHtml(name.charAt(0).toUpperCase())}

                    </div>

                    <h3 style="
                        margin-top:12px;
                        font-size:17px;
                        font-weight:700;
                        color:#1e293b;">

                        ${escapeHtml(name)}

                    </h3>

                    <p style="
                        margin-top:4px;
                        font-size:13px;
                        color:#64748b;">

                        ID Karyawan #${escapeHtml(id)}

                    </p>

                </div>


                <!-- DEPARTEMEN -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;
                    margin-bottom:10px;">

                    <p style="font-size:12px;color:#64748b;">
                        Departemen
                    </p>

                    <p style="
                        margin-top:5px;
                        font-size:14px;
                        font-weight:600;
                        color:#1e293b;">

                        ${escapeHtml(department)}

                    </p>

                </div>


                <!-- JENIS KELAMIN -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;
                    margin-bottom:10px;">

                    <p style="font-size:12px;color:#64748b;">
                        Jenis Kelamin
                    </p>

                    <p style="
                        margin-top:5px;
                        font-size:14px;
                        font-weight:600;
                        color:#1e293b;">

                        ${escapeHtml(gender)}

                    </p>

                </div>


                <!-- JABATAN -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;
                    margin-bottom:10px;">

                    <p style="font-size:12px;color:#64748b;">
                        Jabatan
                    </p>

                    <p style="
                        margin-top:5px;
                        font-size:14px;
                        font-weight:600;
                        color:#1e293b;">

                        ${escapeHtml(position)}

                    </p>

                </div>


                <!-- ALAMAT -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;
                    margin-bottom:10px;">

                    <p style="font-size:12px;color:#64748b;">
                        Alamat
                    </p>

                    <p style="
                        margin-top:5px;
                        font-size:14px;
                        font-weight:600;
                        color:#1e293b;
                        line-height:1.6;
                        word-break:break-word;">

                        ${escapeHtml(address)}

                    </p>

                </div>


                <!-- TANGGAL BERGABUNG -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;
                    margin-bottom:10px;">

                    <p style="font-size:12px;color:#64748b;">
                        Tanggal Bergabung
                    </p>

                    <p style="
                        margin-top:5px;
                        font-size:14px;
                        font-weight:600;
                        color:#1e293b;">

                        ${escapeHtml(joinDate)}

                    </p>

                </div>


                <!-- STATUS -->
                <div style="
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:15px;">

                    <p style="font-size:12px;color:#64748b;">
                        Status Karyawan
                    </p>

                    <span style="
                        display:inline-block;
                        margin-top:7px;
                        padding:5px 12px;
                        border-radius:20px;
                        background:${status === 'Aktif' ? '#d1fae5' : '#fee2e2'};
                        color:${status === 'Aktif' ? '#047857' : '#b91c1c'};
                        font-size:12px;
                        font-weight:600;">

                        ${escapeHtml(status)}

                    </span>

                </div>

            </div>
        `,

        width: 420,
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#2563eb',
        focusConfirm: false,

        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-lg px-6'
        }

    });

});


/* ==========================================
   KONFIRMASI HAPUS KARYAWAN
========================================== */

document.addEventListener('click', function(e) {

    const button = e.target.closest('.delete-employee');

    if (!button) return;

    const form = button.closest('.delete-employee-form');
    const name = button.dataset.name;

    Swal.fire({

        title: 'Hapus Karyawan?',

        text: `Apakah kamu yakin ingin menghapus ${name}? Data yang dihapus tidak dapat dikembalikan.`,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',

        confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus!',
        cancelButtonText: 'Batal',

        reverseButtons: true,

        focusCancel: true,

        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-lg px-5 py-2.5',
            cancelButton: 'rounded-lg px-5 py-2.5'
        }

    }).then((result) => {

        if (result.isConfirmed && form) {

            form.submit();

        }

    });

});


/* ==========================================
   HTML ESCAPE
========================================== */

function escapeHtml(value) {

    return String(value).replace(/[&<>"']/g, function(char) {

        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];

    });

}


/* ==========================================
   NOTIFIKASI SUKSES
========================================== */

document.addEventListener('DOMContentLoaded', function() {

    @if (session('success'))

        Swal.fire({

            icon: 'success',
            title: 'Berhasil!',

            text: @json(session('success')),

            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Oke',

            timer: 2500,
            timerProgressBar: true

        });

    @endif

});

</script>

@endsection
