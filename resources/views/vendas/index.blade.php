<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vendas') }}
            </h2>
            <div class="ml-4">
                <button onclick="showCreateModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nova Venda
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full mb-10">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Data</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendas as $venda)
                                <tr>
                                    <td class="border px-4 py-2">{{ $venda->id }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($venda->data)->format('d/m/Y')  }}</td>
                                    <td class="border px-4 py-2">{{ 'R$' . number_format($venda->total, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" onclick="showModal({{ $venda }})">Ver</a>
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700" onclick="showEditModal({{ $venda }})">Editar</a>
                                        <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Links de paginação -->
                    {{ $vendas->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Criação -->
    <div id="create-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Adicionar Nova Venda</h3>
                <form action="{{ route('vendas.store') }}" method="POST">
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
