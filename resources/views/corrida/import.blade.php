<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Importar Nova Corrida
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">Próxima corrida a ser importada:</span>
                    <span class="ml-2 text-2xl font-bold text-gray-800 dark:text-gray-100">Corrida nº {{ $nextCorrida }}</span>
                </div>

                <form action="{{ route('corrida.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="date_corrida" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Data da Corrida
                        </label>
                        <input
                            type="date"
                            name="date_corrida"
                            id="date_corrida"
                            value="{{ old('date_corrida') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    <div>
                        <label for="csv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Arquivo CSV da Corrida
                        </label>
                        <input
                            type="file"
                            name="csv"
                            id="csv"
                            accept=".csv,.txt"
                            class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Colunas esperadas: POS, Kart, name, NV, TMV, TT, DL, DA, TUV, TV
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition"
                        >
                            Importar e Calcular Pontos
                        </button>
                        <a href="{{ route('ranking.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
