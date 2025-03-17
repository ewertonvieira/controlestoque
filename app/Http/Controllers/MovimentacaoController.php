<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\Compra;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Http\Request;

class MovimentacaoController extends Controller
{
    // ...existing code...

    public function index()
    {
        $movimentacoes = Movimentacao::with('produto')->paginate(80);
        $produtos = Produto::all();
        return view('movimentacoes.index', compact('movimentacoes', 'produtos')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tipo' => 'required|string',
            'quantidade' => 'required|integer',
            'data' => 'required|date',
        ]);

        Movimentacao::create($request->all());

        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação registrada com sucesso.');
    }

    public function registrarCompra($compraId)
    {
        $compra = Compra::findOrFail($compraId);
        foreach ($compra->itens as $item) {
            Movimentacao::create([
                'produto_id' => $item->produto_id,
                'tipo' => 'entrada',
                'quantidade' => $item->quantidade,
                'data' => $compra->data,
            ]);
        }
    }

    public function registrarVenda($vendaId)
    {
        $venda = Venda::findOrFail($vendaId);
        foreach ($venda->itens as $item) {
            Movimentacao::create([
                'produto_id' => $item->produto_id,
                'tipo' => 'saida',
                'quantidade' => $item->quantidade,
                'data' => $venda->data,
            ]);
        }
    }
}
