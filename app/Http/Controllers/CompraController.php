<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\MovimentacaoController;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::paginate(80);
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all(); 
        return view('compras.index', compact('compras', 'fornecedores', 'produtos')); 
    }

    public function create()
    {
        $fornecedores = Fornecedor::all();
        $produtos = Produto::all(); 
        return view('compras.create', compact('fornecedores', 'produtos')); 
    }

    public function store(Request $request)
    {
        $total = 0;

        $compra = Compra::create([
            'fornecedor_id' => $request->fornecedor_id,
            'data' => $request->data,
            'total' => $total
        ]);

        foreach ($request->produtos as $produtoData) {
            $produto = Produto::where('nome', $produtoData['nome'])->first();

            $precoComAumento = $produtoData['preco'] * 1.30; // Adiciona 30% ao preço

            if ($produto) {
                // Atualiza o produto existente
                $produto->update([
                    'preco' => $precoComAumento,
                    'estoque' => $produto->estoque + $produtoData['quantidade'],
                    'estoque_minimo' => $produtoData['estoque_minimo'] ?? $produto->estoque_minimo
                ]);
            } else {
                // Cria um novo produto
                $produto = Produto::create([
                    'nome' => $produtoData['nome'],
                    'preco' => $precoComAumento,
                    'estoque_minimo' => $produtoData['estoque_minimo'] ?? 0,
                    'estoque' => $produtoData['quantidade'],
                    'sku' => strtoupper(Str::random(11))
                ]);
            }

            $compra->itens()->create([
                'produto_id' => $produto->id,
                'quantidade' => $produtoData['quantidade'],
                'preco' => $produtoData['preco'] // Manter o preço original na compra
            ]);

            $total += $produtoData['quantidade'] * $produtoData['preco'];
        }

        // Limitar o valor total para evitar erro de valor fora do intervalo
        $compra->update(['total' => min($total, 99999999.99)]);

        app(MovimentacaoController::class)->registrarCompra($compra->id);
        return redirect()->route('compras.index');
    }

    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, Compra $compra)
    {
        $compra->update($request->all());
        return redirect()->route('compras.index');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index');
    }
}
