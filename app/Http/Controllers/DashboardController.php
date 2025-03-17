<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use App\Models\Compra;
use App\Models\ItemCompra;
use App\Models\ItemVenda;
use App\Models\Movimentacao;
use App\Models\Fornecedor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProdutos = Produto::sum('estoque');
        $valorTotalEstoque = Produto::sum(\DB::raw('estoque * preco'));
        $ultimaAtualizacao = Movimentacao::latest('data')->first()->data ?? 'N/A';

        $categorias = Produto::select('categoria_id')->distinct()->pluck('categoria_id');
        $produtosPorCategoria = Produto::selectRaw('count(*) as count, categoria_id')->groupBy('categoria_id')->pluck('count', 'categoria_id')->toArray();

        $produtosBaixoEstoque = Produto::whereColumn('estoque', '<=', 'estoque_minimo')->get();
        $produtosBaixoEstoqueNomes = $produtosBaixoEstoque->pluck('nome');
        $produtosBaixoEstoqueQuantidades = $produtosBaixoEstoque->pluck('estoque');

        $ultimasVendas = Venda::orderBy('data', 'desc')->take(5)->get();
        $ultimasCompras = Compra::orderBy('data', 'desc')->take(5)->get();
        $movimentacoesRecentes = Movimentacao::orderBy('data', 'desc')->take(5)->get();

        $lucroBruto = Venda::sum('total') - Compra::sum('total');
        $margemLucro = (Compra::sum('total') > 0) ? ($lucroBruto / Compra::sum('total')) * 100 : 0;

        $fornecedores = Fornecedor::all();

        // Estatísticas de entradas e saídas
        $entradas = ItemCompra::sum('quantidade');
        $saidas = ItemVenda::sum('quantidade');

        // Retorna valores para a view
        return view('dashboard', compact(
            'totalProdutos', 'valorTotalEstoque', 'ultimaAtualizacao', 'categorias', 'produtosPorCategoria',
            'produtosBaixoEstoque', 'produtosBaixoEstoqueNomes', 'produtosBaixoEstoqueQuantidades',
            'ultimasVendas', 'ultimasCompras', 'movimentacoesRecentes',
            'lucroBruto', 'margemLucro', 'fornecedores', 'entradas', 'saidas'
        ));
    }
}