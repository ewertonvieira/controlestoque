<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Relatório de Produtos') }}
            </h2>
            <div>
                <form action="{{ route('relatorios.produtos.export', 'csv') }}" method="GET" style="display: inline;">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Exportar CSV</button>
                </form>
                <form action="{{ route('relatorios.produtos.export', 'xlsx') }}" method="GET" style="display: inline;">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Exportar XLSX</button>
                </form>
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
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">SKU</th>
                                <th class="px-4 py-2">Preço</th>
                                <th class="px-4 py-2">Estoque</th>
                                <th class="px-4 py-2">Estoque Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td class="border px-4 py-2">{{ $produto->nome }}</td>
                                    <td class="border px-4 py-2">{{ $produto->sku }}</td>
                                    <td class="border px-4 py-2">{{ $produto->preco }}</td>
                                    <td class="border px-4 py-2">{{ $produto->estoque }}</td>
                                    <td class="border px-4 py-2">{{ $produto->estoque_minimo }}</td>
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
</x-app-layout>
