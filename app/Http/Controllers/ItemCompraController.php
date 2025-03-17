<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCompra;
use App\Models\Produto;
use App\Models\Compra;
use Illuminate\Support\Facades\Log;

class ItemCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itensCompra = ItemCompra::paginate(80);
        $produtos = Produto::all(); 
        $compras = \Schema::hasTable('compra') ? Compra::all() : collect(); 
        return view('itemcompra.index', compact('itensCompra', 'produtos', 'compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all(); 
        $compras = \Schema::hasTable('compra') ? Compra::all() : collect(); 
        return view('itemcompra.create', compact('produtos', 'compras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Dados recebidos para criar ItemCompra:', $request->all());

        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0',
            'produto_id' => 'required|exists:produtos,id', 
            'compra_id' => 'required|exists:compra,id', 
        ]);

        ItemCompra::create($request->all());
        return redirect()->route('itemcompra.index');
    }
}
