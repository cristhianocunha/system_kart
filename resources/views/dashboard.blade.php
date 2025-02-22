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
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Acesse as corridas separadas. </h1>
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <ul>
                    @foreach($corridas as $corrida)
                    <li>
                        <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600"
                            href="{{ route('bateria01.index', ['corrida' => $corrida->corrida] ) }}">Corrida {{ $corrida->corrida }}</button>
                    </li>

                    @endforeach
                </ul>
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