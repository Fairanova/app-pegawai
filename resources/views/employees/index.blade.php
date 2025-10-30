@extends('master')

@section('title', 'Data Karyawan')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Karyawan</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Tambah Karyawan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th class="text-center" style="width: 120px;">Nama Lengkap</th>
                        <th class="text-center" style="width: 150px;">Email</th>
                        <th class="text-center" style="width: 100px;">Telepon</th>
                        <th class="text-center" style="width: 80px;">Tgl Lahir</th>
                        <th class="text-center" style="width: 130px;">Alamat</th>
                        <th class="text-center" style="width: 80px;">Tgl Masuk</th>
                        <th class="text-center" style="width: 80px;">Departemen</th>
                        <th class="text-center" style="width: 120px;">Jabatan</th>
                        <th class="text-center" style="width: 70px;">Status</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $index => $employee)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td style="font-size: 0.85em;">{{ $employee->nama_lengkap }}</td>
                            <td style="font-size: 0.8em;">{{ $employee->email }}</td>
                            <td class="text-center" style="font-size: 0.85em;">{{ $employee->nomor_telepon ?? '-' }}</td>
                            <td class="text-center" style="font-size: 0.85em;">{{ $employee->tanggal_lahir ? date('d/m/Y', strtotime($employee->tanggal_lahir)) : '-' }}</td>
                            <td style="font-size: 0.8em;">{{ Str::limit($employee->alamat, 20) ?? '-' }}</td>
                            <td class="text-center" style="font-size: 0.85em;">{{ $employee->tanggal_masuk ? date('d/m/Y', strtotime($employee->tanggal_masuk)) : '-' }}</td>
                            <td style="font-size: 0.85em;">{{ $employee->department->nama_departemen ?? '-' }}</td>
                            <td style="font-size: 0.85em;">{{ $employee->position->nama_jabatan ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $employee->status == 'aktif' ? 'success' : 'secondary' }}" style="font-size: 0.75em;">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm" style="font-size: 0.75em;">Detail</a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm" style="font-size: 0.75em;">Edit</a>
                                    <button type="button" onclick="confirmDelete({{ $employee->id }}, '{{ $employee->nama_lengkap }}')" class="btn btn-danger btn-sm" style="font-size: 0.75em;">Hapus</button>
                                </div>
                                <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Belum ada data karyawan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($employees->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Menampilkan {{ $employees->firstItem() }} sampai {{ $employees->lastItem() }} dari {{ $employees->total() }} data
                </div>
                <div class="dataTables_paginate">
                    {{ $employees->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Function untuk confirm delete dengan SweetAlert2
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: `Anda akan menghapus karyawan: <strong>"${name}"</strong><br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// Alert untuk success message
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

// Alert untuk error message
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 4000
    });
@endif
</script>
@endsection