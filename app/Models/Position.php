<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    /**
     * Relasi one-to-many ke model Employee.
     * Satu jabatan dapat dimiliki oleh banyak karyawan.
     */    
    public function employees()
    {
        return $this->hasMany(Employee::class, 'jabatan_id');
    }
}
