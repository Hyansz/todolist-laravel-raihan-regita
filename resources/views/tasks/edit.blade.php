@extends('layout.app')

@section('title', 'Edit Todolist')

@section('content')
    <h1>Edit Todolist</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="task">Tugas:</label>
            <input type="text" name="task" id="task" value="{{ old('task', $task->task) }}">
            @error('task')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_completed" {{ $task->is_completed ? 'checked' : '' }}> Selesai
            </label>
        </div>

        <button type="submit" class="btn">Update</button>
    </form>

    <a href="{{ route('tasks.index') }}">← Kembali</a>
@endsection
