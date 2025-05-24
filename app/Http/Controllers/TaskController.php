<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Tampilkan semua task milik user yang login.
     */
    public function index()
    {
        $status = request('status', 'pending'); // default ke 'pending'

        $query = Task::where('user_id', Auth::id());

        if ($status === 'pending') {
            $query->where('is_completed', false)->latest();
        } elseif ($status === 'done') {
            $query->where('is_completed', true)->orderByDesc('updated_at');
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Form untuk membuat task baru.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Simpan task baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'task' => $request->task,
            'is_completed' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Todolist berhasil dibuat!');
    }

    /**
     * Tampilkan detail task tertentu.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Form untuk mengedit task.
     */
    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Simpan perubahan task ke database.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task); // Pastikan user hanya bisa mengubah miliknya

        // Cek apakah hanya update status (dari dropdown)
        if ($request->has('is_completed') && !$request->has('task')) {
            $request->validate([
                'is_completed' => 'required|boolean',
            ]);

            $task->update([
                'is_completed' => $request->is_completed,
            ]);

            return redirect()->route('tasks.index')->with('success', 'Status tugas berhasil diperbarui.');
        }

        // Jika update penuh (task dan is_completed)
        $request->validate([
            'task' => 'required|string|max:255',
            'is_completed' => 'nullable|boolean',
        ]);

        $task->update([
            'task' => $request->task,
            'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Todolist berhasil diperbarui!');
    }

    /**
     * Hapus task dari database.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Todolist berhasil dihapus!');
    }

    /**
     * Pastikan task milik user yang login.
     */
    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }
    }
}
