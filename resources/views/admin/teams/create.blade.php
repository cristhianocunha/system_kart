<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Nova Equipe
            </h2>
            <a href="{{ route('admin.teams.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 rounded">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.teams.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nome da Equipe
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            maxlength="100"
                            placeholder="Ex: Kart Club SP, Racing Team Norte..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                            autofocus
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            O slug para a URL pública é gerado automaticamente.
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition">
                            Criar Equipe
                        </button>
                        <a href="{{ route('admin.teams.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
