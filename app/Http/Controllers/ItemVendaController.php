<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Support\Facades\Log;

class ItemVendaController extends Controller
{
    public function index()
    {
        $itensVenda = ItemVenda::paginate(80);
        $produtos = Produto::all();
        $vendas = Venda::all();
        return view('itemvenda.index', compact('itensVenda', 'produtos', 'vendas'));
    }

    public function create()
    {
        $produtos = Produto::all();
        $vendas = Venda::all();
        return view('itemvenda.create', compact('produtos', 'vendas'));
    }

    public function store(Request $request)
    {
        Log::info('Dados recebidos para criar ItemVenda:', $request->all());

        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0',
            'produto_id' => 'required|exists:produtos,id',
            'venda_id' => 'required|exists:venda,id',
        ]);

        ItemVenda::create($request->all());
        return redirect()->route('itemvenda.index');
    }

    public function show(ItemVenda $itemVenda)
    {
        return view('itemvenda.show', compact('itemVenda'));
    }

    public function edit(ItemVenda $itemVenda)
    {
        return view('itemvenda.edit', compact('itemVenda'));
    }

    public function update(Request $request, ItemVenda $itemVenda)
    {
        $itemVenda->update($request->all());
        return redirect()->route('itemvenda.index');
    }

    public function destroy(ItemVenda $itemVenda)
    {
        $itemVenda->delete();
        return redirect()->route('itemvenda.index');
    }
}
