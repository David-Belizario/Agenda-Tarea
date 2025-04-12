<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Muestra el listado de contactos.
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Muestra el formulario para crear un nuevo contacto.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Almacena un nuevo contacto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos.
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'email'     => 'required|email|unique:contacts,email',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        // Creación del contacto usando asignación masiva.
        Contact::create($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contacto creado con éxito.');
    }

    /**
     * Muestra el formulario para editar un contacto existente.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Actualiza un contacto en la base de datos.
     */
    public function update(Request $request, Contact $contact)
    {
        // Validación de los datos recibidos.
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'email'     => 'required|email|unique:contacts,email,' . $contact->id,
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        // Actualización del contacto.
        $contact->update($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contacto actualizado con éxito.');
    }

    /**
     * Elimina un contacto de la base de datos.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('success', 'Contacto eliminado con éxito.');
    }
}
