<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Relatório de Compras') }}
            </h2>
            <div>
                <form action="{{ route('relatorios.compras.export', 'csv') }}" method="GET" style="display: inline;">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Exportar CSV</button>
                </form>
                <form action="{{ route('relatorios.compras.export', 'xlsx') }}" method="GET" style="display: inline;">
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
                                <th class="px-4 py-2">Data</th>
                                <th class="px-4 py-2">Fornecedor</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Produto</th>
                                <th class="px-4 py-2">Quantidade</th>
                                <th class="px-4 py-2">Preço Unitário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compras as $compra)
                                @foreach ($compra->itens as $item)
                                    <tr>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($compra->data)->format('d/m/Y') }}</td>
                                        <td class="border px-4 py-2">{{ $compra->fornecedor->nome }}</td>
                                        <td class="border px-4 py-2">{{ number_format($compra->total, 2, ',', '.') }}</td>
                                        <td class="border px-4 py-2">{{ $item->produto->nome }}</td>
                                        <td class="border px-4 py-2">{{ $item->quantidade }}</td>
                                        <td class="border px-4 py-2">{{ number_format($item->preco, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Links de paginação -->
                    {{ $compras->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
