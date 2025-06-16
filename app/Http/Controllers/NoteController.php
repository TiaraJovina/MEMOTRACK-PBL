<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // Tampilkan semua catatan milik user yang sedang login
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('notes', [
            'notes' => $notes,
            'role' => Auth::user()->role, // kalau view pakai <x-layout :role="$role">
        ]);
    }

    // Simpan catatan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create([
            'title'    => $validated['title'],
            'content'  => $validated['content'],
            'user_id'  => Auth::id(),
        ]);

        return redirect()->route('notes')->with('success', 'Note created successfully.');
    }

    // Hapus catatan (dengan validasi user yang sesuai)
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();

        return redirect()->route('notes')->with('success', 'Note deleted successfully.');
    }
}
