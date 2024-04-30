<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ApiController extends Controller
{
    public function storeQuote(Request $request)
    {
        // Get data from the request
        $requestData = $request->all();

        // Calculate total price
        $totalPrice = $this->calculateTotalPrice($requestData['product_id'], $requestData['selected_options']);

        // Creaate new quote on DB
        $quote = Quote::create([
            'user_name' => $requestData['user_name'],
            'user_email' => $requestData['user_email'],
            'total_price' => $totalPrice,
        ]);

        // Get selected options
        $selectedOptionsDetails = Option::whereIn('id', $requestData['selected_options'])->get();

        // Associate the selected options with the quote and prices.
        foreach ($selectedOptionsDetails as $option) {
            $quote->options()->attach($option, ['price' => $option->price]);
        }

        return response()->json(['message' => 'Quote created successfully', 'quote' => $quote], 201);
    }


    private function calculateTotalPrice($productId, $selectedOptions)
    {
        // Get base price
        $basePrice = Product::findOrFail($productId)->base_price;

        // Get price of the selected options
        $optionsPrice = Option::whereIn('id', $selectedOptions)->sum('price');
        
        $totalPrice = $basePrice + $optionsPrice;

        return $totalPrice;
    }

    public function indexProducts()
    {
        // Get all the products from DB
        $products = Product::all();

        return response()->json($products);
    }

    public function showProduct($product_id)
    {
        // get especific product with his ID from the DB
        $product = Product::findOrFail($product_id);

        return response()->json($product);
    }
}

