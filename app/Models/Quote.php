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
        return $this->belongsToMany(Option::class, 'option_product')->withPivot('price');
    }


    /**
     * The options associated with the quote.
     */
    public function quoteOptions()
    {
        return $this->belongsToMany(Option::class, 'quote_options')->withPivot('price');
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
        ]);
    
        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->first());
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
    
        try {
            $totalPrice = self::calculateTotalPrice($requestData['product_id'], $requestData['selected_options']);

            // Create new quote
            $quote = self::create([
                'user_name' => $requestData['user_name'],
                'user_email' => $requestData['user_email'],
                'total_price' => $totalPrice,
            ]);
        
            // Get selected options
            $selectedOptionsDetails = Option::whereIn('id', $requestData['selected_options'])->get();
        
            // Associate selected options and prices
            foreach ($selectedOptionsDetails as $option) {
                $quote->quoteOptions()->attach($option->id, ['price' => $option->price]);
            }
        
            \Log::info('Quote created successfully', ['quote' => $quote->toArray()]);

            return $quote;

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Error creating quote:', [$e->getMessage()]);

            return response()->json(['error' => 'Database query error.', 'message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            \Log::error('Error creating quote:', $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the quote.'], 500);
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
    public static function calculateTotalPrice($productId, $selectedOptions)
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
