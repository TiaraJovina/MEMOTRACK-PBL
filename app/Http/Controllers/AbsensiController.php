<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AbsensiController extends Controller
{
    public function index()
    {
        $data = Absensi::orderBy('date', 'desc')->get();
        return view('absensi', compact('data'));
    }

    public function store(Request $request)
    {
         $request->validate([
        'title' => 'required|string',
        'details' => 'required|string',
        'date' => 'required|date',
        ]);

    // Simpan ke DB
    Absensi::create([
        'title' => $request->title,
        'details' => $request->details,
        'date' => $request->date,
        'status' => $request->status, // kalau user = mahasiswa
        'role' => 'dosen', // Atur sesuai kebutuhan
    ]);

     return redirect()->back()->with('success', 'Attendance session added.');
    }

    public function update(Request $request, $id)
{
    
    $data = Absensi::find($id);

    if (!$data) {
        return response()->json(['message' => 'Session not found'], 404);
    }

    $data->update([
        'title' => $request->title,
        'details' => $request->details,
        'date' => $request->date,
    ]);

    return response()->json(['message' => 'Session updated successfully']);

}

public function delete($title)
{
    $data = Absensi::where('title', $title)->first();
    if ($data) {
        $data->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
    return response()->json(['message' => 'Session not found'], 404);
}

    public function markAttendance(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Present,Absent,Late',
        ]);

        $attendance = Absensi::findOrFail($id);
        $attendance->status = $request->status;
        $attendance->save();

        return response()->json(['message' => 'Attendance marked']);
    }
}
