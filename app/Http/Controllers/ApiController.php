<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Option;

class ApiController extends Controller
{
    public function storeQuote(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                'user_name' => 'required|string',
                'user_email' => 'required|email',
                'product_id' => 'required|exists:products,id',
                'selected_options' => 'required|array',
                'selected_options.*' => 'exists:options,id',
            ]);

            // Calculate total price
            $totalPrice = Quote::calculateTotalPrice($validatedData['product_id'], $validatedData['selected_options']);

            // Create new quote
           $quote = Quote::createQuote($validatedData);

            // Log successful quote creation
            \Log::info('Quote created successfully', ['quote' => $quote]);

            // JSON with the created quote
            return response()->json(['message' => 'Quote created successfully', 'quote' => $quote], 201);
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error creating quote', ['exception' => $e]);

            // Return error response
            return response()->json(['error' => 'Failed to create quote', 'message' => $e->getMessage()], 500);
        }
    }




    public function indexProducts()
    {
        // Get all products
        $products = Product::getAllProducts();

        return response()->json($products);
    }

    public function showProduct($product_id)
    {
        // Get product with options
        $product = Product::with('options')->findOrFail($product_id);

        return response()->json($product);
    }
}
