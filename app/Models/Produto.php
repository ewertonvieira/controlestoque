<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';

    protected $fillable = ['categoria_id', 'nome', 'sku', 'preco', 'estoque', 'estoque_minimo'];

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class);
    }

    public function decrementEstoque($quantidade)
    {
        if ($quantidade > $this->estoque) {
            throw new \Exception('Quantidade solicitada excede o estoque disponível.');
        }
        $this->estoque -= $quantidade;
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($produto) {
            $produto->movimentacoes()->delete();
        });
    }
}
