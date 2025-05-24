<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Olá, Piloto {{ Auth::user()->name }} 👋
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <select
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded-md shadow-sm"
                    onchange="window.location.href = this.value">
                    <option value="">Selecione uma corrida</option>
                    @foreach($corridas as $corrida)
                    <option value="{{ route('bateria01.index', ['corrida' => $corrida->corrida] ) }}">
                        Corrida {{ $corrida->corrida }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Sua Melhor volta: {{ $staticUser->TVM }}
                </h2>
            </div>
        </div>
    </div>
</x-app-layout>