<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Venda') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('vendas.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mt-2 px-7 py-3">
                            <div class="mb-4">
                                <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                                <input type="date" id="data" name="data" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="mb-4">
                                <label for="produtos" class="block text-sm font-medium text-gray-700">Produtos</label>
                                <div id="produtos">
                                    <div class="flex mb-2">
                                        <select name="produtos[0][id]" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="updateQuantidadeDisponivel(this)">
                                            <option value="">Selecione um produto</option>
                                            @foreach ($produtos as $produto)
                                                <option value="{{ $produto->id }}" data-estoque="{{ $produto->estoque }}">{{ $produto->nome }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="produtos[0][quantidade]" placeholder="Quantidade" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" oninput="checkQuantidadeDisponivel(this)">
                                        <span class="text-sm text-gray-500">Disponível: <span class="quantidade-disponivel"></span></span>
                                    </div>
                                </div>
                                <button type="button" onclick="addProduto()" class="mt-2 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Adicionar Produto</button>
                            </div>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                Criar Venda
                            </button>
                            <button type="button" id="cancel-create-btn" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
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
                <select name="produtos[${produtoIndex}][id]" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="updateQuantidadeDisponivel(this)">
                    <option value="">Selecione um produto</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}" data-estoque="{{ $produto->estoque }}">{{ $produto->nome }}</option>
                    @endforeach
                </select>
                <input type="number" name="produtos[${produtoIndex}][quantidade]" placeholder="Quantidade" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" oninput="checkQuantidadeDisponivel(this)">
                <span class="text-sm text-gray-500">Disponível: <span class="quantidade-disponivel"></span></span>
            `;
            produtosDiv.appendChild(newProdutoDiv);
            produtoIndex++;
        }

        function updateQuantidadeDisponivel(selectElement) {
            const estoque = selectElement.options[selectElement.selectedIndex].getAttribute('data-estoque');
            const quantidadeDisponivelSpan = selectElement.parentElement.querySelector('.quantidade-disponivel');
            quantidadeDisponivelSpan.textContent = estoque;
        }

        function checkQuantidadeDisponivel(inputElement) {
            const quantidade = parseInt(inputElement.value);
            const estoque = parseInt(inputElement.parentElement.querySelector('select').options[inputElement.parentElement.querySelector('select').selectedIndex].getAttribute('data-estoque'));
            if (quantidade > estoque) {
                alert('Quantidade pedida não disponível no estoque. Quantidade disponível: ' + estoque);
                inputElement.value = '';
            }
        }

        function showCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        document.getElementById('cancel-create-btn').addEventListener('click', function() {
            document.getElementById('create-modal').classList.add('hidden');
        });
    </script>
</x-app-layout>
