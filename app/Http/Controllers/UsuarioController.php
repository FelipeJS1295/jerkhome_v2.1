<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     */
    public function index()
    {
        $usuarios = User::all(); // Obtiene todos los usuarios
        return view('configuracion.usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        return view('configuracion.usuarios.create');
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'rol' => ['required', Rule::in(['Admin', 'Users', 'Tapicería', 'Costura', 'Esqueletería', 'Embalaje', 'Corte', 'Cojinería', 'Bodega'])],
            'activo' => 'required|boolean',
        ]);

        // Crear usuario
        User::create([
            'nombre_usuario' => $validatedData['nombre_usuario'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'rol' => $validatedData['rol'],
            'activo' => $validatedData['activo'],
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('configuracion.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|string',
            'activo' => 'required|boolean',
            'password' => 'nullable|min:8', // El password es opcional
        ]);
    
        // Buscar el usuario
        $usuario = User::findOrFail($id);
    
        // Actualizar datos del usuario
        $usuario->update([
            'nombre_usuario' => $validatedData['nombre_usuario'],
            'email' => $validatedData['email'],
            'rol' => $validatedData['rol'],
            'activo' => $validatedData['activo'],
            // Solo actualizar el password si fue llenado
            'password' => $validatedData['password'] 
                ? Hash::make($validatedData['password']) 
                : $usuario->password,
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
