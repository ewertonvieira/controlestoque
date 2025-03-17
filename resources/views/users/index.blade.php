<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('users') }}
            </h2>

            <!-- Link "Nova Categoria" -->
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full mb-10">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 w-20">ID</th>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Senha</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">{{ $user->id }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $user->name }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $user->email }}</td>
                                    <td class="border px-4 py-2 truncate max-w-[150px]">{{ $user->password }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700" onclick="showModal({{ $user }})">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Links de paginação -->
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

     <div id="product-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detalhes do Usuario</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>ID:</strong> <span id="modal-id"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Nome:</strong> <span id="modal-nome"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Email:</strong> <span id="modal-email"></span></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500"><strong>Password:</strong> <span id="modal-pass"></span></p>
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

    <script>
        function showModal(user) {
            document.getElementById('modal-id').innerText = user.id;
            document.getElementById('modal-nome').innerText = user.name;
            document.getElementById('modal-email').innerText = user.email;
            document.getElementById('modal-pass').innerText = user.password;
            document.getElementById('product-modal').classList.remove('hidden');
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
