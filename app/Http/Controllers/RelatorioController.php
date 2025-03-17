<?php

namespace App\Http\Controllers;

use App\Exports\ComprasExport;
use App\Exports\ProdutosExport;
use App\Exports\VendasExport;
use App\Models\Venda;
use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function vendas()
    {
        $vendas = Venda::with('itens.produto')->paginate(80);
        return view('relatorios.vendas', compact('vendas'));
    }

    public function compras()
    {
        $compras = Compra::with('itens.produto')->paginate(80);
        return view('relatorios.compras', compact('compras'));
    }

    public function produtos()
    {
        $produtos = Produto::paginate(80);
        return view('relatorios.produtos', compact('produtos'));
    }

    public function exportVendas($format)
    {
        $export = new VendasExport();
        return $export->export($format);
    }

    public function exportCompras($format)
    {
        $export = new ComprasExport();
        return $export->export($format);
    }

    public function exportProdutos($format)
    {
        $export = new ProdutosExport();
        return $export->export($format);
    }
}
