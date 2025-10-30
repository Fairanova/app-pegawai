@extends('master')

@section('title', 'Data Departemen')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Departemen</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">+ Tambah Departemen</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Departemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departments as $index => $department)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $department->nama_departemen }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info">Detail</a>
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" onclick="confirmDelete({{ $department->id }}, '{{ $department->nama_departemen }}')" class="btn btn-danger">Hapus</button>
                                    </div>
                                    <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data departemen</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($departments->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Menampilkan {{ $departments->firstItem() }} sampai {{ $departments->lastItem() }} dari {{ $departments->total() }} data
                </div>
                <div class="dataTables_paginate">
                    {{ $departments->links() }}
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
        html: `Anda akan menghapus departemen: <strong>"${name}"</strong><br><span class="text-danger">Data yang dihapus tidak dapat dikembalikan!</span>`,
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