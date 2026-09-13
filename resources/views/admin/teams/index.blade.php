<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Equipes
            </h2>
            <a href="{{ route('admin.teams.create') }}"
               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow transition">
                + Nova Equipe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Nome da Equipe</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3 text-center">Membros</th>
                            <th class="px-6 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($teams as $team)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                {{ $team->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-mono text-xs">
                                {{ $team->slug }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-700 dark:text-gray-300">
                                {{ $team->users_count }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ route('admin.teams.edit', $team) }}"
                                       class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                                        Editar
                                    </a>
                                    <a href="{{ route('ranking.public', $team->slug) }}"
                                       class="text-gray-500 dark:text-gray-400 hover:underline text-sm">
                                        Ver Ranking
                                    </a>
                                    @if($team->users_count === 0)
                                    <form action="{{ route('admin.teams.destroy', $team) }}" method="POST"
                                          onsubmit="return confirm('Excluir a equipe \"{{ $team->name }}\"?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:underline text-sm font-medium">
                                            Excluir
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500">
                                Nenhuma equipe criada ainda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
