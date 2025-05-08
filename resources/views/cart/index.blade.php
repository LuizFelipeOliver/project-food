@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Meu Carrinho</h1>
    
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if(!empty($cart))
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg">
                <thead>
                    <tr class="text-left bg-gray-100 dark:bg-gray-600">
                        <th class="py-3 px-4 font-semibold text-gray-700 dark:text-white">Produto</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 dark:text-white">Preço</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 dark:text-white">Quantidade</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 dark:text-white">Total</th>
                        <th class="py-3 px-4 font-semibold text-gray-700 dark:text-white">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($cart as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="py-3 px-4 flex items-center">
                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="w-16 h-16 rounded-lg mr-4 object-cover">
                                <span class="text-gray-900 dark:text-white">{{ $item['product']->name }}</span>
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 p-1 rounded text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700">
                                    <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded">Atualizar</button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex items-center justify-between">
            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Total: R$ {{ number_format(array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0), 2, ',', '.') }}</h4>
            
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Limpar Carrinho</button>
            </form>
        </div>
    @else
        <p class="text-gray-700 dark:text-gray-300 mt-4">Seu carrinho está vazio.</p>
    @endif
</div>
@endsection
