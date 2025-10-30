@extends('master')

@section('title', 'Tambah Jabatan Baru')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Tambah Jabatan Baru</h2>
    </div>

    <div class="card shadow-sm">
        <form action="{{ route('positions.store') }}" method="POST" id="positionForm">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" 
                           id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}" 
                           placeholder="Masukkan nama jabatan" required>
                    @error('nama_jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" 
                               id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" 
                               placeholder="Masukkan gaji pokok" step="0.01" min="0" required>
                    </div>
                    @error('gaji_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Format: Angka tanpa titik (contoh: 5000000 untuk 5 juta)</div>
                </div>
            </div>
            
            <!-- Tombol Simpan dan Kembali di card footer (bawah card) -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('positions.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

// Alert untuk error validation
@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan!',
        html: `@foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach`
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