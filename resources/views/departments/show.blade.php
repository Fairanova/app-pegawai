@extends('master')

@section('title', 'Detail Departemen')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Departemen</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary mb-3">Informasi Departemen</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">ID</td>
                            <td>{{ $department->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nama Departemen</td>
                            <td>{{ $department->nama_departemen }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h5 class="text-primary mb-3">Statistik</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="60%" class="fw-bold">Jumlah Karyawan</td>
                            <td>
                                <span class="badge bg-primary">{{ $department->employees->count() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="text-primary mb-3">Data Sistem</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="20%" class="fw-bold">Dibuat</td>
                            <td>{{ $department->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diupdate</td>
                            <td>{{ $department->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Tombol Kembali di card footer (bawah card) -->
        <div class="card-footer">
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali</a>
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
</script>

<style>
.table-borderless td {
    padding: 8px 12px;
    border: none !important;
}
.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 1rem;
}
</style>
@endsection