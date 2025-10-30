@extends('master')

@section('title', 'Data Absensi')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Absensi</h2>
        <a href="{{ route('attendances.create') }}" class="btn btn-primary">+ Tambah Absensi</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $index => $attendance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $attendance->employee->nama_karyawan ?? $attendance->employee->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ date('d/m/Y', strtotime($attendance->tanggal)) }}</td>
                                <td>{{ $attendance->waktu_masuk ? date('H:i', strtotime($attendance->waktu_masuk)) : '-' }}</td>
                                <td>{{ $attendance->waktu_keluar ? date('H:i', strtotime($attendance->waktu_keluar)) : '-' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'hadir' => 'success',
                                            'izin' => 'warning',
                                            'sakit' => 'info',
                                            'alpha' => 'danger'
                                        ];
                                        $color = $statusColors[$attendance->status_absensi] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($attendance->status_absensi) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('attendances.show', $attendance->id) }}" class="btn btn-info">Detail</a>
                                        <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" onclick="confirmDelete({{ $attendance->id }}, '{{ $attendance->employee->nama_karyawan ?? $attendance->employee->nama_lengkap ?? 'N/A' }} - {{ date('d/m/Y', strtotime($attendance->tanggal)) }}')" class="btn btn-danger">Hapus</button>
                                    </div>
                                    <form id="delete-form-{{ $attendance->id }}" action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($attendances->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Menampilkan {{ $attendances->firstItem() }} sampai {{ $attendances->lastItem() }} dari {{ $attendances->total() }} data
                </div>
                <div class="dataTables_paginate">
                    {{ $attendances->links() }}
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
        html: `Anda akan menghapus absensi: <strong>"${name}"</strong><br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
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