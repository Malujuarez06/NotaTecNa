@extends('layouts.app')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #4a4a4a;
        }

        .search-bar {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-bar button {
            background-color: #5a6268;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-bar button:hover {
            background-color: #343a40;
        }

        .btn-create {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .btn-create a {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-create a:hover {
            background-color: #495057;
        }

        .note-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .note-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .note-title {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(to right, #6c757d, #343a40);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .note-content {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }

        .note-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
        }

        .btn-group a,
        .btn-group button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #f0ad4e;
        }

        .btn-edit:hover {
            background-color: #ec971f;
        }

        .btn-delete {
            background-color: #d9534f;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        .btn-pdf {
            background-color: #6f42c1;
        }

        .btn-pdf:hover {
            background-color: #5a32a1;
        }

        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            color: #5a6268;
            text-decoration: none;
            margin: 0 5px;
            font-size: 16px;
        }

        .pagination .page-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        <h1 class="form-title">Notas</h1>

        <!-- Barra de búsqueda -->
        <form action="{{ route('notes.index') }}" method="GET" class="search-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar...">
            <button type="submit">Buscar</button>
        </form>

        <!-- Botón de creación de notas -->
        <div class="btn-create">
            <a href="{{ route('notes.create') }}">Crear Nueva Nota</a>
        </div>

        <!-- Lista de notas -->
        <div class="note-list">
            @foreach($notes as $note)
                <div class="note-card">
                    <h2 class="note-title">{{ $note->titulo }}</h2>
                    <p class="note-content">{{ \Illuminate\Support\Str::limit($note->contenido, 150) }}</p>

                    <!-- Imagen de la nota -->
                    @if($note->imagen)
                        <img src="{{ asset('storage/' . $note->imagen) }}" alt="Imagen de la nota" class="note-image">
                    @endif

                    <div class="btn-group">
                        <div>
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">Editar</a>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar esta nota?')">Eliminar</button>
                            </form>
                        </div>
                        <a href="{{ route('notes.pdf', $note->id) }}" class="btn-pdf">Generar PDF</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="pagination">
            {{ $notes->links() }}
        </div>
    </div>
@endsection
