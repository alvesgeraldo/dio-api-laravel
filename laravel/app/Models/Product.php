<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $fillable = [
        'nomeProduto',
        'qtdeEstoque',
        'valor'
    ];
    public $timestamps = false;
    protected $primaryKey = 'idProduto';

    public static function createProduct($data)
    {
        return self::create($data);
    }
}
