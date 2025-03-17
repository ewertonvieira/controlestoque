<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Movimentações de Estoque') }}
            </h2>
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
                                <th class="px-4 py-2">Produto</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2">Quantidade</th>
                                <th class="px-4 py-2">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movimentacoes as $movimentacao)
                                <tr>
                                    <td class="border px-4 py-2">{{ $movimentacao->id }}</td>
                                    <td class="border px-4 py-2">{{ $movimentacao->produto->nome }}</td>
                                    <td class="border px-4 py-2">{{ $movimentacao->tipo }}</td>
                                    <td class="border px-4 py-2">{{ number_format($movimentacao->quantidade, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($movimentacao->data)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Links de paginação -->
                    {{ $movimentacoes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
