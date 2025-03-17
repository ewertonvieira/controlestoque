<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Resumo Geral -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Resumo Geral</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">Quantidade total de produtos em estoque</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalProdutos }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">Valor total de estoque</p>
                            <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($valorTotalEstoque, 2, ',', '.') }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">Última atualização</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ strftime('%d/%m/%Y', strtotime($ultimaAtualizacao)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Gráficos e Indicadores -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Gráficos e Indicadores</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <canvas id="entradasSaidas"></canvas>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <canvas id="produtosBaixoEstoque"></canvas>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg col-span-2">
                            <canvas id="vendasCompras"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Movimentações Recentes -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Movimentações Recentes</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="text-md font-medium text-gray-700">Últimas Vendas</h4>
                            <ul>
                                @foreach ($ultimasVendas as $venda)
                                    <li>
                                        {{ strftime('%d/%m/%Y', strtotime($venda->data)) }} - R$ {{ number_format($venda->total, 2, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="text-md font-medium text-gray-700">Últimas Compras</h4>
                            <ul>
                                @foreach ($ultimasCompras as $compra)
                                    <li>
                                        {{ strftime('%d/%m/%Y', strtotime($compra->data)) }} - R$ {{ number_format($compra->total, 2, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="text-md font-medium text-gray-700">Entrada e Saída de Estoque</h4>
                            <ul>
                                @foreach ($movimentacoesRecentes as $movimentacao)
                                    <li>
                                        {{ strftime('%d/%m/%Y', strtotime($movimentacao->data)) }} - {{ $movimentacao->tipo }} - {{ $movimentacao->quantidade }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Alertas e Notificações -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Alertas e Notificações</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="text-md font-medium text-gray-700">Avisos de Baixo Estoque</h4>
                            <ul>
                                @foreach ($produtosBaixoEstoque as $produto)
                                    <li>{{ $produto->nome }} - {{ $produto->estoque }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Ações Rápidas</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <a href="{{ route('produtos.create') }}" class="p-4 bg-blue-600 text-white rounded-lg text-center">Adicionar Novo Produto</a>
                        <a href="{{ route('compras.create') }}" class="p-4 bg-red-500 text-white rounded-lg text-center">Registrar Nova Compra</a>
                        <a href="{{ route('vendas.create') }}" class="p-4 bg-green-600 text-white rounded-lg text-center">Registrar Nova Venda</a>
                        @if (Route::has('export.excel'))
                            <a href="{{ route('export.excel') }}" class="p-4 bg-yellow-500 text-white rounded-lg text-center">Exportar para Excel</a>
                        @endif
                    </div>
                </div>

                <!-- Indicadores Financeiros -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Indicadores Financeiros</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">Lucro Bruto</p>
                            <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($lucroBruto, 2, ',', '.') }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p class="text-sm font-medium text-PhpSpreadsheetgray-600">Margem de Lucro</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($margemLucro, 2, ',', '.') }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Integrações e Parceiros -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Integrações e Parceiros</h3>
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <h4 class="text-md font-medium text-gray-700">Fornecedores</h4>
                        <ul>
                            @foreach ($fornecedores as $fornecedor)
                                <li>{{ $fornecedor->nome }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para formatar datas no formato 'dd/mm/yyyy'
        function formatDate(dateString) {
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('pt-BR', options);
        }

        // Gráfico de Entradas e Saídas
        const ctxEntradasSaidas = document.getElementById('entradasSaidas').getContext('2d');
        const entradasSaidasChart = new Chart(ctxEntradasSaidas, {
            type: 'pie',
            data: {
                labels: ['Entradas', 'Saídas'],
                datasets: [{
                    data: [{{ $entradas }}, {{ $saidas }}],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            }
        });

        // Gráfico de Produtos com Estoque Baixo
        const ctxProdutosBaixoEstoque = document.getElementById('produtosBaixoEstoque').getContext('2d');
        const produtosBaixoEstoqueChart = new Chart(ctxProdutosBaixoEstoque, {
            type: 'bar',
            data: {
                labels: @json($produtosBaixoEstoqueNomes),
                datasets: [{
                    label: 'Quantidade',
                    data: @json($produtosBaixoEstoqueQuantidades),
                    backgroundColor: '#FF6384'
                }]
            }
        });

        // Gráfico de Vendas e Compras
        const ctxVendasCompras = document.getElementById('vendasCompras').getContext('2d');
        const vendasComprasChart = new Chart(ctxVendasCompras, {
            type: 'line',
            data: {
                labels: @json($movimentacoesRecentes->pluck('data')->map(function($data) {
                    return strftime('%d/%m/%Y', strtotime($data));
                })),
                datasets: [
                    {
                        label: 'Vendas',
                        data: @json($ultimasVendas->pluck('total')),
                        borderColor: '#36A2EB',
                        fill: false
                    },
                    {
                        label: 'Compras',
                        data: @json($ultimasCompras->pluck('total')),
                        borderColor: '#FF6384',
                        fill: false
                    }
                ]
            }
        });
    </script>
</x-app-layout>
