<?php

namespace App\Http\Controllers;

use App\Models\Pintura;
use App\Models\Artista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PinturaController extends Controller
{
    /**
     * Muestra el listado de pinturas junto con los datos de su artista.
     */
    public function index()
    {
        // Con with('artista') cargamos la relación para saber quién pintó cada cuadro
        $pinturas = Pintura::with('artista')->get();
        return Inertia::render('Pinturas/Index', [
            'pinturas' => $pinturas
        ]);
    }

    /**
     * Muestra el formulario de creación pasándole los artistas disponibles.
     */
    public function create()
    {
        $artistas = Artista::all();
        return Inertia::render('Pinturas/Create', [
            'artistas' => $artistas
        ]);
    }

    /**
     * Guarda la nueva pintura e incluye el procesamiento de la imagen.
     */
    public function store(Request $request)
    {
        $request->validate([
            'artista_id' => 'required|exists:artistas,id',
            'titulo' => 'required|string|max:255',
            'tecnica' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB
        ]);

        $data = $request->only(['artista_id', 'titulo', 'tecnica', 'precio']);

        // Si subió una foto, la guardamos en el disco público
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('pinturas', 'public');
            $data['imagen'] = '/storage/' . $path;
        }

        Pintura::create($data);

        return redirect()->route('pinturas.index')->with('success', 'Pintura registrada con éxito.');
    }

    /**
     * Muestra el detalle de una pintura (opcional).
     */
    public function show(Pintura $pintura)
    {
        return Inertia::render('Pinturas/Show', [
            'pintura' => $pintura->load('artista')
        ]);
    }

    /**
     * Muestra el formulario para editar pasándole la pintura y los artistas.
     */
    public function edit(Pintura $pintura)
    {
        $artistas = Artista::all();
        return Inertia::render('Pinturas/Edit', [
            'pintura' => $pintura,
            'artistas' => $artistas
        ]);
    }

    /**
     * Actualiza la pintura y reemplaza la imagen vieja si se sube una nueva.
     */
    public function update(Request $request, Pintura $pintura)
    {
        $request->validate([
            'artista_id' => 'required|exists:artistas,id',
            'titulo' => 'required|string|max:255',
            'tecnica' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['artista_id', 'titulo', 'tecnica', 'precio']);

        if ($request->hasFile('imagen')) {
            // Borramos la imagen anterior si existía para no llenar el disco de basura
            if ($pintura->imagen) {
                $oldPath = str_replace('/storage/', '', $pintura->imagen);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('imagen')->store('pinturas', 'public');
            $data['imagen'] = '/storage/' . $path;
        }

        $pintura->update($data);

        return redirect()->route('pinturas.index')->with('success', 'Pintura actualizada con éxito.');
    }

    /**
     * Elimina la pintura de la base de datos junto con su archivo de imagen.
     */
    public function destroy(Pintura $pintura)
    {
        if ($pintura->imagen) {
            $path = str_replace('/storage/', '', $pintura->imagen);
            Storage::disk('public')->delete($path);
        }

        $pintura->delete();

        return redirect()->route('pinturas.index')->with('success', 'Pintura eliminada con éxito.');
    }
}