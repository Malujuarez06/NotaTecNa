<!-- resources/views/notes/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Nota PDF</title>
</head>
<body>
    <h1>{{ $note->title }}</h1>
    <p>{{ $note->content }}</p>
    @if ($note->image_path)
        <img src="{{ public_path('storage/' . $note->image_path) }}" alt="Imagen" width="200">
    @endif
</body>
</html>