<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::all();
        return Inertia::render('Alumnos/Index', ['alumnos' => $alumnos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'grado' => 'required|string|max:100',
            'seccion' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
        ]);

        Alumno::create($request->all());
        return redirect()->route('alumnos.index');
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'grado' => 'required|string|max:100',
            'seccion' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
        ]);

        $alumno->update($request->all());
        return redirect()->route('alumnos.index');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index');
    }
}
