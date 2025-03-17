<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nova Compra') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('compras.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="fornecedor_id" class="block text-sm font-medium text-gray-700">Fornecedor</label>
                        <select id="fornecedor_id" name="fornecedor_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Selecione um fornecedor</option>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                        <input type="date" id="data" name="data" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="produtos" class="block text-sm font-medium text-gray-700">Produtos</label>
                        <div id="produtos">
                            <div class="flex mb-2">
                                <input type="text" name="produtos[0][nome]" placeholder="Nome do Produto" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <input type="number" name="produtos[0][quantidade]" placeholder="Quantidade" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <input type="number" name="produtos[0][preco]" placeholder="Preço" step="0.01" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <input type="number" name="produtos[0][estoque_minimo]" placeholder="Estoque Mínimo" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                        <button type="button" onclick="addProduto()" class="mt-2 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Adicionar Produto
                        </button>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Registrar Compra
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let produtoIndex = 1;

        function addProduto() {
            const produtosDiv = document.getElementById('produtos');
            const newProdutoDiv = document.createElement('div');
            newProdutoDiv.classList.add('flex', 'mb-2');
            newProdutoDiv.innerHTML = `
                <input type="text" name="produtos[${produtoIndex}][nome]" placeholder="Nome do Produto" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][quantidade]" placeholder="Quantidade" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][preco]" placeholder="Preço" step="0.01" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][estoque_minimo]" placeholder="Estoque Mínimo" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            `;
            produtosDiv.appendChild(newProdutoDiv);
            produtoIndex++;
        }
    </script>
</x-app-layout>