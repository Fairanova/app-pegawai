@extends('master')

@section('title', 'Data Jabatan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Jabatan</h2>
        <a href="{{ route('positions.create') }}" class="btn btn-primary">+ Tambah Jabatan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $index => $position)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $position->nama_jabatan }}</td>
                                <td>Rp {{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('positions.show', $position->id) }}" class="btn btn-info">Detail</a>
                                        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" onclick="confirmDelete({{ $position->id }}, '{{ $position->nama_jabatan }}')" class="btn btn-danger">Hapus</button>
                                    </div>
                                    <form id="delete-form-{{ $position->id }}" action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data jabatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($positions->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Menampilkan {{ $positions->firstItem() }} sampai {{ $positions->lastItem() }} dari {{ $positions->total() }} data
                </div>
                <div class="dataTables_paginate">
                    {{ $positions->links() }}
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
        html: `Anda akan menghapus jabatan: <strong>"${name}"</strong><br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
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