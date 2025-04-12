<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold leading-tight text-gray-800">Mis Contactos</h2>
                <a href="{{ route('contacts.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    + Nuevo Contacto
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-left text-gray-600 font-semibold">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Teléfono</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($contacts as $contact)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $contact->nombre }}</td>
                                <td class="px-6 py-4">{{ $contact->telefono }}</td>
                                <td class="px-6 py-4">{{ $contact->email }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('contacts.edit', $contact) }}"
                                        class="text-blue-600 hover:underline">Editar</a>

                                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar este contacto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($contacts->isEmpty())
                    <p class="text-center py-4 text-gray-500">No hay contactos registrados.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
