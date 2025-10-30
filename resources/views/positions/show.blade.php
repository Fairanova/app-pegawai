@extends('master')

@section('title', 'Detail Jabatan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Jabatan</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">ID Jabatan:</div>
                <div class="col-md-9">{{ $position->id }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama Jabatan:</div>
                <div class="col-md-9">
                    <h5 class="text-primary">{{ $position->nama_jabatan }}</h5>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Gaji Pokok:</div>
                <div class="col-md-9">
                    <h4 class="text-success">Rp {{ number_format($position->gaji_pokok, 2, ',', '.') }}</h4>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Dibuat Pada:</div>
                <div class="col-md-9">
                    {{ $position->created_at->format('d F Y H:i:s') }}
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 fw-bold">Diupdate Pada:</div>
                <div class="col-md-9">
                    {{ $position->updated_at->format('d F Y H:i:s') }}
                </div>
            </div>
        </div>
        
        <!-- Tombol Aksi di card footer (bawah card) -->
        <div class="card-footer">
            <a href="{{ route('positions.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form-{{ $position->id }}" action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

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

<style>
.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 1rem;
}
</style>
@endsection