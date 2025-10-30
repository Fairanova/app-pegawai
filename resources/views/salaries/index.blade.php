@extends('master')

@section('title', 'Data Gaji')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Gaji</h2>
        <a href="{{ route('salaries.create') }}" class="btn btn-primary">+ Tambah Gaji</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Bulan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Total Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salaries as $index => $salary)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $salary->employee->nama_karyawan ?? $salary->employee->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $salary->bulan }}</td>
                                <td>Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($salary->potongan, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}</strong></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('salaries.show', $salary->id) }}" class="btn btn-info">Detail</a>
                                        <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" onclick="confirmDelete({{ $salary->id }}, '{{ $salary->employee->nama_karyawan ?? $salary->employee->nama_lengkap ?? 'N/A' }} - {{ $salary->bulan }}')" class="btn btn-danger">Hapus</button>
                                    </div>
                                    <form id="delete-form-{{ $salary->id }}" action="{{ route('salaries.destroy', $salary->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data gaji</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($salaries->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Menampilkan {{ $salaries->firstItem() }} sampai {{ $salaries->lastItem() }} dari {{ $salaries->total() }} data
                </div>
                <div class="dataTables_paginate">
                    {{ $salaries->links() }}
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
        html: `Anda akan menghapus data gaji: <strong>"${name}"</strong><br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
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