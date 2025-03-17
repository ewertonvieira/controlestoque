<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produtos') }}
            </h2>

            <!-- Link "Novo Produto" -->
            <div class="ml-4">
                <button onclick="showCreateModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Novo Produto
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
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">SKU</th>
                                <th class="px-4 py-2">Preço</th>
                                <th class="px-4 py-2">Estoque</th>
                                <th class="px-4 py-2">Estoque mínimo</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td class="border px-4 py-2">{{ $produto->id }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $produto->nome }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $produto->sku }}</td>
                                    <td class="border px-4 py-2">{{ 'R$' . number_format($produto->preco, 2, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ number_format($produto->estoque, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ number_format($produto->estoque_minimo, 0, ',', '.') }}</td>                                    
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" onclick="showModal({{ $produto }})">Ver</a>
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700" onclick="showEditModal({{ $produto }})">Editar</a>
                                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline;">
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
                    {{ $produtos->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Criação -->
    <div id="create-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Adicionar Novo Produto</h3>
                <form action="{{ route('produtos.store') }}" method="POST">
                    @csrf
                    <div class="mt-2 px-7 py-3">
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="preco" class="block text-sm font-medium text-gray-700">Preço</label>
                            <input type="number" id="preco" name="preco" required step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="estoque" class="block text-sm font-medium text-gray-700">Estoque</label>
                            <input type="number" id="estoque" name="estoque" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="estoque_minimo" class="block text-sm font-medium text-gray-700">Estoque Mínimo</label>
                            <input type="number" id="estoque_minimo" name="estoque_minimo" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select id="categoria_id" name="categoria_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Selecione uma categoria</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Criar Produto
                        </button>
                        <button type="button" id="cancel-create-btn" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <div id="product-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detalhes do Produto</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>ID:</strong> <span id="modal-id"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Nome:</strong> <span id="modal-nome"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>SKU:</strong> <span id="modal-sku"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Preço:</strong> <span id="modal-preco"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Estoque:</strong> <span id="modal-estoque"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Estoque Mínimo:</strong> <span id="modal-estoque-minimo"></span></p>
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
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="edit-modal-title">Editar Produto</h3>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 px-7 py-3">
                        <div class="mb-4">
                            <label for="edit-nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="edit-nome" name="nome" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-preco" class="block text-sm font-medium text-gray-700">Preço</label>
                            <input type="text" id="edit-preco" name="preco" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-estoque" class="block text-sm font-medium text-gray-700">Estoque</label>
                            <input type="text" id="edit-estoque" name="estoque" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-estoque-minimo" class="block text-sm font-medium text-gray-700">Estoque Mínimo</label>
                            <input type="text" id="edit-estoque-minimo" name="estoque_minimo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
        function showModal(produto) {
            document.getElementById('modal-id').innerText = produto.id;
            document.getElementById('modal-nome').innerText = produto.nome;
            document.getElementById('modal-preco').innerText = 'R$ ' + Number(produto.preco).toFixed(2).replace('.', ',');
            document.getElementById('modal-estoque').innerText = produto.estoque;
            document.getElementById('modal-estoque-minimo').innerText = produto.estoque_minimo;
            document.getElementById('product-modal').classList.remove('hidden');
        }

        function showEditModal(produto) {
            document.getElementById('edit-nome').value = produto.nome;
            document.getElementById('edit-preco').value = produto.preco;
            document.getElementById('edit-estoque').value = produto.estoque;
            document.getElementById('edit-estoque-minimo').value = produto.estoque_minimo;
            document.getElementById('edit-form').action = '/produtos/' + produto.id;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function showCreateModal() {
            document.getElementById('create-modal').classList.remove('hidden');
        }

        document.getElementById('ok-btn').addEventListener('click', function() {
            document.getElementById('product-modal').classList.add('hidden');
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        document.getElementById('cancel-create-btn').addEventListener('click', function() {
            document.getElementById('create-modal').classList.add('hidden');
        });
    </script>
</x-app-layout>
