<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('fornecedores') }}
            </h2>

            <!-- Link "Nova Categoria" -->
            <div class="ml-4">
                <button onclick="showCreateModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Novo Fornecedor
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
                                <th class="px-4 py-2">Contato</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fornecedores as $fornecedor)
                                <tr>
                                    <td class="border px-4 py-2">{{ $fornecedor->id }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $fornecedor->nome }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $fornecedor->contato }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $fornecedor->email }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" onclick="showModal({{ $fornecedor }})">Ver</a>
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700" onclick="showEditModal({{ $fornecedor }})">Editar</a>
                                        <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" style="display:inline;">
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
                    {{ $fornecedores->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Criação -->
    <div id="create-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Adicionar Novo Fornecedor</h3>
                <form action="{{ route('fornecedores.store') }}" method="POST">
                    @csrf
                    <div class="mt-2 px-7 py-3">
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Contato</label>
                            <input type="tel" id="contato" name="contato" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Criar Fornecedor
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
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detalhes da Categoria</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>ID:</strong> <span id="modal-id"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Nome:</strong> <span id="modal-nome"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Contato:</strong> <span id="modal-contato"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Email:</strong> <span id="modal-email"></span></p>
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
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="edit-modal-title">Editar Categoria</h3>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 px-7 py-3">
                        <div class="mb-4">
                            <label for="edit-nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="edit-nome" name="nome" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-nome" class="block text-sm font-medium text-gray-700">Contato</label>
                            <input type="text" id="edit-contato" name="contato" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <label for="edit-nome" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" id="edit-email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
        function showModal(fornecedor) {
            document.getElementById('modal-id').innerText = fornecedor.id;
            document.getElementById('modal-nome').innerText = fornecedor.nome;
            document.getElementById('modal-contato').innerText = fornecedor.contato;
            document.getElementById('modal-email').innerText = fornecedor.email;
            document.getElementById('product-modal').classList.remove('hidden');
        }

        function showEditModal(fornecedor) {
            document.getElementById('edit-nome').value = fornecedor.nome;
            document.getElementById('edit-contato').value = fornecedor.contato;
            document.getElementById('edit-email').value = fornecedor.email;
            document.getElementById('edit-form').action = '/fornecedores/' + fornecedor.id;
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
