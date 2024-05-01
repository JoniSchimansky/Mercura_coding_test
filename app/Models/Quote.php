<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_email',
        'total_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * The options associated with the quote.
     */
    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot('price');
    }

    /**
     * Create a new quote with the given information.
     *
     * @param  array  $requestData
     * @return \App\Models\Quote
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function createQuote(array $requestData)
    {
        // Validate entry data
        $validator = Validator::make($requestData, [
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'product_id' => 'required|exists:products,id',
            'selected_options' => 'required|array',
            'selected_options.*' => 'exists:options,id',
        ]);

        // Validation errors
        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        try {
            // Calculate total price
            $totalPrice = static::calculateTotalPrice($requestData['product_id'], $requestData['selected_options']);

            // Create new quote on DB
            $quote = static::create([
                'user_name' => $requestData['user_name'],
                'user_email' => $requestData['user_email'],
                'total_price' => $totalPrice,
            ]);

            // Get selected options
            $selectedOptionsDetails = Option::whereIn('id', $requestData['selected_options'])->get();

            // Associate selected options with the quote and price
            foreach ($selectedOptionsDetails as $option) {
                $quote->options()->attach($option, ['price' => $option->price]);
            }

            return $quote;
        } catch (\Exception $e) {
            throw new \RuntimeException('An error occurred while creating the quote.');
        }
    }

    /**
     * Calculate the total price of the quote.
     *
     * @param  int  $productId
     * @param  array  $selectedOptions
     * @return float
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private static function calculateTotalPrice($productId, $selectedOptions)
    {
        // Get product base price
        $basePrice = Product::findOrFail($productId)->base_price;

        // Get selected options price
        $optionsPrice = Option::whereIn('id', $selectedOptions)->sum('price');
        
        // Calculate total price
        $totalPrice = $basePrice + $optionsPrice;

        return $totalPrice;
    }
}
