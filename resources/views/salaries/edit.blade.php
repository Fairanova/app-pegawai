@extends('master')

@section('title', 'Edit Gaji')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Edit Gaji</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label">Nama Karyawan <span class="text-danger">*</span></label>
                    <select class="form-control @error('karyawan_id') is-invalid @enderror" 
                            id="karyawan_id" name="karyawan_id" required onchange="loadEmployeeData()">
                        <option value="">Pilih Karyawan</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" 
                                    data-position-id="{{ $employee->jabatan_id }}"
                                    {{ old('karyawan_id', $salary->karyawan_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                    <input type="month" class="form-control @error('bulan') is-invalid @enderror" 
                           id="bulan" name="bulan" value="{{ old('bulan', $salary->bulan) }}" 
                           required>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" 
                               id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $salary->gaji_pokok) }}" 
                               step="0.01" min="0" readonly required>
                    </div>
                    @error('gaji_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Gaji pokok berdasarkan jabatan karyawan</div>
                </div>

                <div class="mb-3">
                    <label for="tunjangan" class="form-label">Tunjangan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('tunjangan') is-invalid @enderror" 
                               id="tunjangan" name="tunjangan" value="{{ old('tunjangan', $salary->tunjangan) }}" 
                               placeholder="Masukkan tunjangan" step="0.01" min="0" oninput="calculateTotal()">
                    </div>
                    @error('tunjangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="potongan" class="form-label">Potongan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('potongan') is-invalid @enderror" 
                               id="potongan" name="potongan" value="{{ old('potongan', $salary->potongan) }}" 
                               placeholder="Masukkan potongan" step="0.01" min="0" oninput="calculateTotal()">
                    </div>
                    @error('potongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="total_gaji" class="form-label">Total Gaji</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('total_gaji') is-invalid @enderror" 
                               id="total_gaji" name="total_gaji" value="{{ old('total_gaji', $salary->total_gaji) }}" 
                               step="0.01" min="0" readonly>
                    </div>
                    @error('total_gaji')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Data gaji pokok berdasarkan jabatan
const positionSalaries = {
    @foreach($positions as $position)
        {{ $position->id }}: {{ $position->gaji_pokok }},
    @endforeach
};

// Function untuk load data karyawan dan gaji pokok
function loadEmployeeData() {
    const karyawanSelect = document.getElementById('karyawan_id');
    const selectedOption = karyawanSelect.options[karyawanSelect.selectedIndex];
    const positionId = selectedOption.getAttribute('data-position-id');
    const gajiPokokInput = document.getElementById('gaji_pokok');
    
    if (positionId && positionSalaries[positionId]) {
        gajiPokokInput.value = positionSalaries[positionId];
    }
    
    calculateTotal();
}

// Function untuk menghitung total gaji otomatis
function calculateTotal() {
    const gajiPokok = parseFloat(document.getElementById('gaji_pokok').value) || 0;
    const tunjangan = parseFloat(document.getElementById('tunjangan').value) || 0;
    const potongan = parseFloat(document.getElementById('potongan').value) || 0;
    const totalGaji = (gajiPokok + tunjangan) - potongan;
    
    document.getElementById('total_gaji').value = totalGaji > 0 ? totalGaji.toFixed(2) : '0';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
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
@endsection