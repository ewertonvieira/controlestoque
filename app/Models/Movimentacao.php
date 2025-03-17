<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacao';

    protected $fillable = ['produto_id', 'tipo', 'quantidade', 'data'];

    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
