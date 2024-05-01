<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'price',
        'item_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * The options associated with the product.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price');
    }

    public function quotes()
    {
        return $this->belongsToMany(Quote::class)->withPivot('price');
    }

    /**
     * Get a specific option.
     *
     * @param  int  $optionId
     * @return \App\Models\Option
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function getOption($optionId)
    {
        return Option::findOrFail($optionId);
    }
}
