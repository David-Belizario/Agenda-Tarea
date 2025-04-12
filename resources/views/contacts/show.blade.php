<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-6 bg-white rounded shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detalle del Contacto</h2>

        <div class="space-y-4 text-gray-700">
            <div>
                <span class="font-semibold">Nombre:</span> {{ $contact->nombre }}
            </div>
            <div>
                <span class="font-semibold">Email:</span> {{ $contact->email }}
            </div>
            <div>
                <span class="font-semibold">Teléfono:</span> {{ $contact->telefono }}
            </div>
            <div>
                <span class="font-semibold">Dirección:</span> {{ $contact->direccion }}
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('contacts.index') }}"
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded transition">
                ← Volver a la lista
            </a>
        </div>
    </div>
</x-app-layout>
