@extends('layout.app')

@section('title', 'Daftar Todolist')

@section('content')
    <style>
        /* Container tombol & filter */
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Dropdown filter */
        .filter-select {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
            cursor: pointer;
            background-color: white;
            transition: box-shadow 0.3s ease;
            margin: 0px;
        }

        /* Shadow saat focus */
        .filter-select:focus {
            outline: none;
            box-shadow: 0 0 6px 2px rgba(78, 84, 200, 0.6);
        }

        /* Label di sebelah dropdown */
        .filter-label {
            font-weight: 600;
            margin-right: 0.5rem;
            user-select: none;
            margin-bottom: 0px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .top-left {
            display: flex;
            align-items: center;
        }

        .top-left svg {
            margin-right: 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            background: white;
            color: black;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            border: 1px solid black;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: rgba(255, 0, 0, 0.814);
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 8px;
        }

        .dropdown-menu button {
            color: white;
            padding: 0.75rem 1rem;
            background: none;
            font-weight: bold;
            border: none;
            text-align: left;
            width: 100%;
            cursor: pointer;
        }

        .task-list-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 2px;
            padding-top: 1rem;
            margin-top: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #fafafa;
            scrollbar-width: thin;
        }

        .task-list-container::-webkit-scrollbar {
            width: 6px;
        }

        .task-list-container::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 6px;
        }

        .card h4 {
            margin-bottom: 0.75rem;
            margin-top: 0px;
        }

        .card form,
        .card a,
        .card button {
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .card form select {
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
    </style>

    <div class="top-bar">
        <div class="top-left">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square" viewBox="0 0 24 24">
                <path d="M9 11l3 3L22 4"></path>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <h1 style="margin: 0;">Daftar Todolist</h1>
        </div>

        <div class="dropdown">
            <button class="dropdown-toggle" onclick="toggleDropdown()">
                👤 
                {{ Auth::user()->name }}
            </button>
            <div class="dropdown-menu" id="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="filter-container">
        <a href="{{ route('tasks.create') }}" class="btn">Tambah Task</a>

        <form method="GET" action="{{ route('tasks.index') }}" style="display: flex; align-items: center;">
            <label for="filter" class="filter-label">Status:</label>
            <select name="status" id="filter" onchange="this.form.submit()" class="filter-select">
                <option value="">None</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </form>
    </div>

    <div class="task-list-container">
        @forelse($tasks as $task)
            <div class="card">
                <h4 class="{{ $task->is_completed ? 'done' : '' }}">{{ $task->task }}</h4>

                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="is_completed" onchange="this.form.submit()">
                        <option value="0" {{ !$task->is_completed ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $task->is_completed ? 'selected' : '' }}>Done</option>
                    </select>
                </form>

                <div class="action-buttons">
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm">Detail</a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('delete-{{ $task->id }}')">Delete</button>
                </div>

                <form id="delete-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <p style="text-align: center; padding: 1rem;">Tidak ada data task.</p>
        @endforelse
    </div>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function (e) {
            const toggle = document.querySelector('.dropdown-toggle');
            const menu = document.getElementById('dropdown-menu');
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    </script>
@endsection
