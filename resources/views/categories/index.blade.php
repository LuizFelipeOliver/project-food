@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 dark:text-gray-200">Gerenciar Categorias</h2>

    {{-- Feedback --}}
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    {{-- Formulário de criação/edição --}}
    <form
        method="POST"
        action="{{ $mode === 'edit' ? route('categories.update', $category->id) : route('categories.store') }}"
        class="space-y-4"
    >
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif

        <div>
            <label class="block font-medium dark:text-gray-200">Nome</label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full border px-3 py-2 rounded" required>
            @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ $mode === 'edit' ? 'Atualizar' : 'Criar' }}
            </button>
            @if($mode === 'edit')
                <a href="{{ route('categories.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
            @endif
        </div>
    </form>

    {{-- Tabela de categorias --}}
    <table class="w-full mt-6 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-3 py-2 text-left">ID</th>
                <th class="px-3 py-2 text-left">Nome</th>
                <th class="px-3 py-2 text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                <tr class="border-t">
                    <td class="px-3 py-2 dark:text-gray-200">{{ $cat->id }}</td>
                    <td class="px-3 py-2 dark:text-gray-200">{{ $cat->name }}</td>
                    <td class="px-3 py-2 text-center space-x-2 dark:text-gray-20">
                        <a href="{{ route('categories.edit', $cat) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>

                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Tem certeza que deseja excluir?')" class="bg-red-600 text-white px-2 py-1 rounded">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
