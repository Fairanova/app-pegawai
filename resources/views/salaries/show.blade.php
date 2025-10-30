@extends('master')

@section('title', 'Detail Gaji')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Gaji</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Informasi Karyawan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 40%;" class="fw-semibold">Nama Karyawan</td>
                            <td>: {{ $salary->employee->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jabatan</td>
                            <td>: {{ $salary->employee->position->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Departemen</td>
                            <td>: {{ $salary->employee->department->nama_departemen ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Informasi Periode</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 40%;" class="fw-semibold">Bulan</td>
                            <td>: {{ \Carbon\Carbon::parse($salary->bulan)->translatedFormat('F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tanggal Input</td>
                            <td>: {{ \Carbon\Carbon::parse($salary->created_at)->translatedFormat('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Terakhir Diupdate</td>
                            <td>: {{ \Carbon\Carbon::parse($salary->updated_at)->translatedFormat('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Rincian Gaji</h5>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <td class="fw-semibold">Gaji Pokok</td>
                            <td class="text-end">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tunjangan</td>
                            <td class="text-end">Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Potongan</td>
                            <td class="text-end text-danger">- Rp {{ number_format($salary->potongan, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-success">
                            <td class="fw-bold fs-5">Total Gaji</td>
                            <td class="text-end fw-bold fs-5">Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($salary->keterangan)
            <div class="mt-3">
                <h5 class="fw-bold mb-2">Keterangan</h5>
                <div class="card bg-light">
                    <div class="card-body">
                        {{ $salary->keterangan }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Tombol Kembali di kiri bawah -->
            <div class="mt-4">
                <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
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
</script>

<style>
.table-borderless td {
    border: none !important;
    padding: 8px 0;
}
</style>
@endsection