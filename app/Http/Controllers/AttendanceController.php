<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index()
    {
        $attendances = Attendance::with('employee')->oldest()->paginate(10);
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all(); 
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
        ]);

        $data = $request->all();
        
        if ($request->status_absensi !== 'hadir') {
            $data['waktu_masuk'] = null;
            $data['waktu_keluar'] = null;
        } else {
            
            $request->validate([
                'waktu_masuk' => 'required|date_format:H:i',
                'waktu_keluar' => 'required|date_format:H:i',
            ]);
        }

        Attendance::create($data);

        return redirect()->route('attendances.index')
                        ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        
        return view('attendances.edit', compact('attendance', 'employees')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'karyawan_id' => 'required|exists:employees,id',
        'tanggal' => 'required|date',
        'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        'waktu_masuk' => 'nullable|required_if:status_absensi,hadir|date_format:H:i',
        'waktu_keluar' => 'nullable|required_if:status_absensi,hadir|date_format:H:i'
    ]);

    $attendance = Attendance::findOrFail($id);
    
    $data = [
        'karyawan_id' => $request->karyawan_id,
        'tanggal' => $request->tanggal,
        'status_absensi' => $request->status_absensi,
        'waktu_masuk' => $request->status_absensi == 'hadir' ? $request->waktu_masuk : null,
        'waktu_keluar' => $request->status_absensi == 'hadir' ? $request->waktu_keluar : null,
    ];

    $attendance->update($data);

    return redirect()->route('attendances.index')->with('success', 'Absensi berhasil diperbarui');

    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendances.index') 
                        ->with('success', 'Data absensi berhasil dihapus.');
    }
}