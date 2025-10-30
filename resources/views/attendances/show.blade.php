@extends('master')

@section('title', 'Detail Absensi')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Absensi</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">ID Absensi:</div>
                <div class="col-md-9">{{ $attendance->id }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama Karyawan:</div>
                <div class="col-md-9">
                    <h5 class="text-primary">{{ $attendance->employee->nama_karyawan ?? $attendance->employee->nama_lengkap ?? 'N/A' }}</h5>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal:</div>
                <div class="col-md-9">
                    {{ date('d F Y', strtotime($attendance->tanggal)) }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status Absensi:</div>
                <div class="col-md-9">
                    @php
                        $statusColors = [
                            'hadir' => 'success',
                            'izin' => 'warning',
                            'sakit' => 'info',
                            'alpha' => 'danger'
                        ];
                        $color = $statusColors[$attendance->status_absensi] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }} fs-6">
                        {{ ucfirst($attendance->status_absensi) }}
                    </span>
                </div>
            </div>

            @if($attendance->status_absensi == 'hadir')
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Waktu Masuk:</div>
                <div class="col-md-9">
                    {{ $attendance->waktu_masuk ? date('H:i', strtotime($attendance->waktu_masuk)) : '-' }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Waktu Keluar:</div>
                <div class="col-md-9">
                    {{ $attendance->waktu_keluar ? date('H:i', strtotime($attendance->waktu_keluar)) : '-' }}
                </div>
            </div>
            @endif
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Dibuat Pada:</div>
                <div class="col-md-9">
                    {{ date('d F Y H:i:s', strtotime($attendance->created_at)) }}
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 fw-bold">Diupdate Pada:</div>
                <div class="col-md-9">
                    {{ date('d F Y H:i:s', strtotime($attendance->updated_at)) }}
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
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