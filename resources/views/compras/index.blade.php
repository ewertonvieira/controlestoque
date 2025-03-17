<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Compras') }}
            </h2>

            <!-- Link "Nova Compra" -->
            <div class="ml-4">
                <button onclick="showCreateModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nova Compra
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
                                <th class="px-4 py-2">Fornecedor</th>
                                <th class="px-4 py-2">Data</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compras as $compra)
                                <tr>
                                    <td class="border px-4 py-2">{{ $compra->id }}</td>
                                    <td class="border px-4 py-2">{{ $compra->fornecedor ? $compra->fornecedor->nome : 'Fornecedor não encontrado' }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($compra->data)->format('d/m/Y') }}</td>
                                    <td class="border px-4 py-2">{{ 'R$' . number_format($compra->total, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" onclick="showModal({{ $compra }})">Ver</a>
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700" onclick="showEditModal({{ $compra }})">Editar</a>
                                        <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
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
                    {{ $compras->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Criação -->
    <div id="create-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Adicionar Nova Compra</h3>
                <form id="create-form" action="{{ route('compras.store') }}" method="POST">
                    @csrf
                    <div class="mt-2 px-7 py-3">
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
                            <button type="button" onclick="addProduto()" class="mt-2 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Adicionar Produto</button>
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Criar Compra
                        </button>
                        <button type="button" id="cancel-create-btn" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div id="compra-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detalhes da Compra</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>ID:</strong> <span id="modal-id"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Fornecedor:</strong> <span id="modal-fornecedor"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Data:</strong> <span id="modal-data"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Total:</strong> <span id="modal-total"></span></p>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="ok-btn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="edit-modal-title">Editar Compra</h3>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 px-7 py-3">
                        <div class="mb-4">
                            <label for="edit-fornecedor_id" class="block text-sm font-medium text-gray-700">Fornecedor</label>
                            <select id="edit-fornecedor_id" name="fornecedor_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @foreach ($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit-data" class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" id="edit-data" name="data" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-total" class="block text-sm font-medium text-gray-700">Total</label>
                            <input type="number" id="edit-total" name="total" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Salvar
                        </button>
                        <button type="button" id="cancel-btn" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
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
                <input type="text" name="produtos[${produtoIndex}][nome]" placeholder="Nome do Produto" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][quantidade]" placeholder="Quantidade" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][preco]" placeholder="Preço" step="0.01" class="mr-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="produtos[${produtoIndex}][estoque_minimo]" placeholder="Estoque Mínimo" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            `;
            produtosDiv.appendChild(newProdutoDiv);
            produtoIndex++;
        }

        function showModal(compra) {
            document.getElementById('modal-id').innerText = compra.id;
            document.getElementById('modal-fornecedor').innerText = compra.fornecedor.nome;
            document.getElementById('modal-data').innerText = compra.data;
            document.getElementById('modal-total').innerText = 'R$ ' + Number(compra.total).toFixed(2).replace('.', ',');
            document.getElementById('compra-modal').classList.remove('hidden');
        }

        function showEditModal(compra) {
            document.getElementById('edit-fornecedor_id').value = compra.fornecedor_id;
            document.getElementById('edit-data').value = compra.data;
            document.getElementById('edit-total').value = compra.total;
            document.getElementById('edit-form').action = '/compras/' + compra.id;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function showCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        document.getElementById('ok-btn').addEventListener('click', function() {
            document.getElementById('compra-modal').classList.add('hidden');
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        document.getElementById('cancel-create-btn').addEventListener('click', function() {
            document.getElementById('create-modal').classList.add('hidden');
        });

        document.getElementById('create-form').addEventListener('submit', function(event) {
            const produtos = document.querySelectorAll('#produtos input[name^="produtos"]');
            produtos.forEach(function(input) {
                if (input.name.includes('[preco]')) {
                    input.value = parseFloat(input.value).toFixed(2); // Manter o preço original
                }
            });
        });
    </script>
</x-app-layout>
