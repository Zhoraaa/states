<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'descripton', 'cost', 'image', 'product_type'];

    public function category()
    {
        return $this->belongsTo(ProductType::class, 'type');
    }
    public function __get($key)
    {
        if ($key == 'category') {
            return $this->category()->first()->name;
        }
        return parent::__get($key);
    }
}
