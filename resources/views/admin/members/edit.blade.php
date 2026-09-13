<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Membro
            </h2>
            <a href="{{ route('admin.members.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                ← Voltar para lista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('admin.members.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nome
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            maxlength="50"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    <div>
                        <label for="pilot_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nome do piloto no CSV
                        </label>
                        <input
                            type="text"
                            name="pilot_name"
                            id="pilot_name"
                            value="{{ old('pilot_name', $user->pilot_name) }}"
                            maxlength="50"
                            placeholder="Ex: Milton, Rogério, Davi..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Nome exatamente como aparece na coluna <code>name</code> do CSV.
                        </p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            E-mail
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>

                    @if(Auth::user()->isSuperAdmin())
                    <div>
                        <label for="team_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Equipe
                        </label>
                        <select
                            name="team_id"
                            id="team_id"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">— sem equipe —</option>
                            @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id', $user->team_id) == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="is_admin"
                            id="is_admin"
                            value="1"
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                            class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        >
                        <label for="is_admin" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Administrador
                        </label>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                            Redefinir senha <span class="text-gray-400 font-normal">(deixe em branco para não alterar)</span>
                        </p>

                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Nova senha
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    minlength="8"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Se preenchida, o membro será obrigado a trocar a senha no próximo login.
                                </p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Confirmar nova senha
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    minlength="8"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition"
                        >
                            Salvar alterações
                        </button>
                        <a href="{{ route('admin.members.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
