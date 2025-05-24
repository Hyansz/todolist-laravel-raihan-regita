@extends('layout.app')

@section('title', 'Detail Todolist')

@section('content')
    <h1>Detail Todolist</h1>

    <div class="card">
        <p><strong>Tugas:</strong> {{ $task->task }}</p>
        <p><strong>Status:</strong> {{ $task->is_completed ? 'Selesai' : 'Pending' }}</p>
        <p><strong>Dibuat:</strong> {{ $task->created_at->diffForHumans() }}</p>
    </div>

    <a href="{{ route('tasks.index') }}">← Kembali</a>
@endsection
