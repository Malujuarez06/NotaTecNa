<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF; // Importa la librería de PDF

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $notes = Note::where('titulo', 'like', "%$search%")
            ->orWhere('contenido', 'like', "%$search%")
            ->paginate(10);
        return view('notes.index', compact('notes', 'search'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        // Validación de la entrada del formulario
        $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Guardar la imagen si existe
        $imagen = $request->file('imagen') ? $request->file('imagen')->store('imagenes', 'public') : null;

        // Crear la nueva nota
        Note::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $imagen,
        ]);

        return redirect()->route('notes.index')->with('success', 'Nota creada con éxito');
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        // Validación de la entrada del formulario
        $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Verificar si se ha cargado una nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($note->imagen) {
                Storage::disk('public')->delete($note->imagen);
            }
            // Guardar la nueva imagen
            $note->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        // Actualizar los datos de la nota
        $note->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $note->imagen, // No olvides actualizar el campo imagen
        ]);

        return redirect()->route('notes.index')->with('success', 'Nota actualizada con éxito');
    }

    public function destroy(Note $note)
    {
        // Eliminar la imagen asociada a la nota si existe
        if ($note->imagen) {
            Storage::disk('public')->delete($note->imagen);
        }
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Nota eliminada con éxito');
    }

    public function generarPDF($id)
    {
        $note = Note::findOrFail($id);
        $pdf = PDF::loadView('notes.pdf', compact('note'));
        return $pdf->download('note_' . $note->id . '.pdf');
    }
}