<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Tampilkan daftar tugas ke view
    public function index()
    {
        // Jika ingin hanya menampilkan tugas yang dibuat oleh dosen ini:
        // $tasks = Task::where('user_id', Auth::id())->orderBy('due_date')->get();

        $tasks = Task::orderBy('due_date')->get(); // Menampilkan semua tugas
        return view('tasks', compact('tasks'));
    }

    // Simpan tugas baru (dosen)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Task::create([
            'title' => $request->title,
            'details' => $request->details,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(), // ✅ Penting agar tidak error 1364
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Update tugas (dosen)
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $task->update([
            'title' => $request->title,
            'details' => $request->details,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Hapus tugas (dosen)
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // Submit tugas (mahasiswa)
    public function submit(Request $request, Task $task)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file(s)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('submissions');

                // Jika kamu punya tabel submissions, kamu bisa simpan di sana:
                // Submission::create([
                //     'task_id' => $task->id,
                //     'user_id' => Auth::id(),
                //     'file_path' => $path,
                // ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Assignment submitted successfully.');
    }
}
