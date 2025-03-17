<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCompra extends Model
{
    use HasFactory;

    protected $table = 'itemcompra';

    protected $fillable = ['compra_id', 'produto_id', 'quantidade', 'preco'];

    public $timestamps = false;

    public function compra()
    {
        return $this->belongsTo(Compra::class);
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
