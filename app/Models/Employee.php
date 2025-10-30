<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'departemen_id',
        'jabatan_id',
        'status',
    ];

    /**
     * Relasi many-to-one ke model Department
     * Banyak karyawan dapat berada dalam satu departemen yang sama
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    /**
     * Relasi many-to-one ke model Position
     * Banyak karyawan bisa punya satu jabatan
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan_id');
    }

    /** 
     * Relasi one-to-many ke model Attendance
     * Satu karyawan dapat memiliki banyak catatan absensi
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }

    /**
     * Relasi one-to-many ke model Salary
     * Satu karyawan dapat memiliki banyak record gaji (per bulan)
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class, 'karyawan_id');
    }
}