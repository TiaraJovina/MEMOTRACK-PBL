<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Tampilkan semua jadwal milik user yang login
    public function index()
    {
        $jadwals = Jadwal::where('user_id', Auth::id())->orderBy('scheduled_at')->get();
        return view('jadwal', compact('jadwals'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);

        Jadwal::create([
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Perbarui jadwal
    public function update(Request $request, Jadwal $jadwal)
    {
        // Pastikan hanya pemilik jadwal yang boleh mengedit
        if ($jadwal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);

        $jadwal->update([
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // Hapus jadwal
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Schedule deleted successfully.');
    }

}
