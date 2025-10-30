@extends('master')

@section('title', 'Tambah Absensi')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Tambah Absensi</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label">Nama Karyawan <span class="text-danger">*</span></label>
                    <select class="form-control @error('karyawan_id') is-invalid @enderror" 
                            id="karyawan_id" name="karyawan_id" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('karyawan_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->nama_karyawan ?? $employee->nama_lengkap ?? 'Nama Kosong' }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                        id="tanggal" name="tanggal" value="{{ old('tanggal') }}" 
                        required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status_absensi" class="form-label">Status Absensi <span class="text-danger">*</span></label>
                    <select class="form-control @error('status_absensi') is-invalid @enderror" 
                            id="status_absensi" name="status_absensi" required onchange="toggleTimeFields()">
                        <option value="">Pilih Status</option>
                        <option value="hadir" {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                    @error('status_absensi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="waktu-container">
                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                        <input type="time" class="form-control @error('waktu_masuk') is-invalid @enderror" 
                               id="waktu_masuk" name="waktu_masuk" value="{{ old('waktu_masuk') }}">
                        @error('waktu_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                        <input type="time" class="form-control @error('waktu_keluar') is-invalid @enderror" 
                               id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar') }}">
                        @error('waktu_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Function untuk show atau hide waktu berdasarkan status
function toggleTimeFields() {
    const status = document.getElementById('status_absensi').value;
    const waktuMasuk = document.getElementById('waktu_masuk');
    const waktuKeluar = document.getElementById('waktu_keluar');
    const waktuContainer = document.getElementById('waktu-container');
    
    if (status === 'hadir') {
        waktuContainer.style.display = 'block';
        waktuMasuk.required = true;
        waktuKeluar.required = true;
    } else {
        waktuContainer.style.display = 'none';
        waktuMasuk.required = false;
        waktuKeluar.required = false;
        waktuMasuk.value = '';
        waktuKeluar.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTimeFields();
});

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
#waktu-container {
    transition: all 0.3s ease;
}
</style>
@endsection