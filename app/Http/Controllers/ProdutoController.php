<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::orderBy('id', 'asc')->paginate(80);
        $categorias = Categoria::all(); 
        return view('produtos.index', compact('produtos', 'categorias')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cria um novo produto
        $categorias = Categoria::all();
        return view('produtos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida os dados do produto
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'estoque' => 'required|integer',
            'estoque_minimo' => 'required|integer',
            'categoria_id' => 'required|exists:categoria,id', 
        ]);

        // Gera um SKU único
        $sku = strtoupper(Str::random(11));

        // Cria um novo produto
        Produto::create([
            'nome' => $request->nome,
            'sku' => $sku,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'estoque_minimo' => $request->estoque_minimo,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('produtos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        // Mostra um produto específico
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        // Edita um produto específico
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        // Valida os dados do produto
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'estoque' => 'required|integer',
            'estoque_minimo' => 'required|integer',
        ]);

        // Atualiza os dados do produto
        $produto->update($request->all());

        return redirect()->route('produtos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        // Deleta um produto específico
        $produto->delete();
        return redirect()->route('produtos.index');
    }

    public function getProdutos()
    {
        return Produto::all();
    }

    public function decrementEstoque($produtoId, $quantidade)
    {
        $produto = Produto::findOrFail($produtoId);
        if ($quantidade > $produto->estoque) {
            throw new \Exception('Quantidade solicitada excede o estoque disponível.');
        }
        $produto->decrement('estoque', $quantidade);
    }
}
