<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    
    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji'
    ];

    /**
     * Relasi many-to-one ke model Employee
     * Setiap gaji dimiliki oleh satu karyawan.
     */    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}