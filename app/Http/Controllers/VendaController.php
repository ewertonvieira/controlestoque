<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Controllers\MovimentacaoController;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::paginate(80);
        $produtos = Produto::all();
        return view('vendas.index', compact('vendas', 'produtos'));
    }

    public function create()
    {
        $produtos = Produto::all();
        return view('vendas.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $total = 0;

        $venda = Venda::create([
            'data' => $request->data,
            'total' => $total
        ]);

        foreach ($request->produtos as $produtoData) {
            $produto = Produto::findOrFail($produtoData['id']);
            $preco = $produto->preco;
            $quantidade = $produtoData['quantidade'];

            if ($quantidade > $produto->estoque) {
                return redirect()->back()->withErrors(['quantidade' => 'Quantidade solicitada para o produto ' . $produto->nome . ' excede o estoque disponível. Estoque disponível: ' . $produto->estoque]);
            }

            $venda->itens()->create([
                'produto_id' => $produto->id,
                'quantidade' => $quantidade,
                'preco' => $preco
            ]);

            $produto->decrementEstoque($quantidade);

            $total += $quantidade * $preco;
        }

        $venda->update(['total' => $total]);

        app(MovimentacaoController::class)->registrarVenda($venda->id);
        return redirect()->route('vendas.index')->with('success', 'Venda criada com sucesso');
    }

    public function show(Venda $venda)
    {
        return view('vendas.show', compact('venda'));
    }

    public function edit(Venda $venda)
    {
        $produtos = Produto::all();
        return view('vendas.edit', compact('venda', 'produtos'));
    }

    public function update(Request $request, Venda $venda)
    {
        $venda->update($request->all());
        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda deletada com sucesso');
    }
}
