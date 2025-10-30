@extends('master')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Karyawan</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pribadi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">Nama Lengkap</td>
                            <td>{{ $employee->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email</td>
                            <td>{{ $employee->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nomor Telepon</td>
                            <td>{{ $employee->nomor_telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Lahir</td>
                            <td>{{ $employee->tanggal_lahir ? \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fas fa-briefcase me-2"></i>Informasi Kerja</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">Departemen</td>
                            <td>{{ $employee->department->nama_departemen ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jabatan</td>
                            <td>{{ $employee->position->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Masuk</td>
                            <td>{{ $employee->tanggal_masuk ? \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td>
                                <span class="badge bg-{{ $employee->status == 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap</h5>
                    <div class="border p-3 rounded bg-light">
                        {!! nl2br(e($employee->alamat)) ?? '<em class="text-muted">Tidak ada alamat</em>' !!}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="text-primary mb-3"><i class="fas fa-history me-2"></i>Data Sistem</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="20%" class="fw-bold">Dibuat</td>
                            <td>{{ $employee->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diupdate</td>
                            <td>{{ $employee->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

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
    padding: 8px 12px;
    border: none !important;
}
</style>
@endsection