<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Todolist')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(-45deg, #74ebd5, #acb6e5, #e0c3fc, #8ec5fc);
            background-size: 400% 400%;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 4rem auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card {
            background: #fff;
            padding: 1.25rem;
            margin: 0 0 1rem 1rem;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            transform: translateY(-3px);
            transition: 0.2s ease-in-out;
        }

        .done {
            text-decoration: line-through;
            color: gray;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            animation: fadeIn 0.4s ease;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            background: #4e54c8;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
            margin-right: 0.5rem;
        }

        .btn:hover {
            background: #3b3f9b;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f1c40f;
            color: #333;
        }

        .btn-warning:hover {
            background: #d4ac0d;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input[type="text"], select, textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.2);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        footer {
            text-align: center;
            margin-top: 3rem;
            color: rgba(0, 0, 0, 0.5);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" id="flash-message">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} Todolist App. Made with B-JE.
    </footer>

    <script>
        const msg = document.getElementById('flash-message');
        if (msg) {
            setTimeout(() => msg.remove(), 3000);
        }

        function confirmDelete(formId) {
            if (confirm('Yakin ingin menghapus task ini?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
</body>
</html>
