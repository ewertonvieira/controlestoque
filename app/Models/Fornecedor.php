<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fornecedor extends Model
{
    //

    use HasFactory;

    protected $table = 'fornecedor';

    protected $fillable = ['nome', 'contato', 'email'];

    public $timestamps = false;

}
