@extends('layouts.app')

@section('content')
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-group .error-message {
            color: #e3342f;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-group img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-top: 10px;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #495057;
        }
    </style>

    <div class="form-container">
        <h1 class="form-title">Editar Nota</h1>

        <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $note->titulo) }}" required>
                @error('titulo')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contenido">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5" required>{{ old('contenido', $note->contenido) }}</textarea>
                @error('contenido')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagen">Imagen (opcional)</label>
                <input type="file" name="imagen" id="imagen">
                @error('imagen')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                @if ($note->imagen)
                    <img src="{{ asset('storage/' . $note->imagen) }}" alt="Imagen de la nota">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Nota</button>
        </form>

        <a href="{{ route('notes.index') }}" class="back-link">Volver a la lista</a>
    </div>
@endsection
