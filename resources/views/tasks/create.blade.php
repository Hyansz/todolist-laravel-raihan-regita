@extends('layout.app')

@section('title', 'Tambah Todolist')

@section('content')
    <h1>Buat Todolist Baru</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="task">Tugas:</label>
            <input type="text" name="task" id="task" value="{{ old('task') }}">
            @error('task')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan</button>
    </form>

    <a href="{{ route('tasks.index') }}">← Kembali</a>
@endsection
