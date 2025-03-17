<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemVenda extends Model
{
    use HasFactory;

    protected $table = 'itemvenda';

    protected $fillable = ['venda_id', 'produto_id', 'quantidade', 'preco'];

    public $timestamps = false;

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getTotal()
    {
        return $this->quantidade * $this->preco;
    }
}
