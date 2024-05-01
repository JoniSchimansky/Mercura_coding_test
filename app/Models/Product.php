<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    /**
     * The options associated with the product.
     */
    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot('price');
    }
    
    /**
     * The quotes associated with the product.
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Get all products with basic information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllProducts()
    {
        return Product::all();
    }
}
