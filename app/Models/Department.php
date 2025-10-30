<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_departemen', 
        
    ];

    /**
     * Relasi one-to-many ke model Employee.
     * Satu departemen dapat memiliki banyak karyawan.
     */    
    public function employees()
    {
        return $this->hasMany(Employee::class, 'departemen_id');
    }
}
