<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistaController extends Controller
{
    /**
     * Muestra el listado de artistas.
     */
    public function index()
    {
        $artistas = Artista::all();
        return Inertia::render('Artistas/Index', [
            'artistas' => $artistas
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo artista.
     */
    public function create()
    {
        return Inertia::render('Artistas/Create');
    }

    /**
     * Guarda el nuevo artista en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
        ]);

        Artista::create($validated);

        return redirect()->route('artistas.index')->with('success', 'Artista creado con éxito.');
    }

    /**
     * Muestra el detalle de un artista específico (opcional).
     */
    public function show(Artista $artista)
    {
        return Inertia::render('Artistas/Show', [
            'artista' => $artista
        ]);
    }

    /**
     * Muestra el formulario para editar un artista existente.
     */
    public function edit(Artista $artista)
    {
        return Inertia::render('Artistas/Edit', [
            'artista' => $artista
        ]);
    }

    /**
     * Actualiza los datos del artista en la base de datos.
     */
    public function update(Request $request, Artista $artista)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
        ]);

        $artista->update($validated);

        return redirect()->route('artistas.index')->with('success', 'Artista actualizado con éxito.');
    }

    /**
     * Elimina un artista de la base de datos.
     */
    public function destroy(Artista $artista)
    {
        $artista->delete();

        return redirect()->route('artistas.index')->with('success', 'Artista eliminado con éxito.');
    }
}