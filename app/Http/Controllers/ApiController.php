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
        // Validate request
        $validatedData = $request->validate([
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'product_id' => 'required|exists:products,id',
            'selected_options' => 'required|array',
            'selected_options.*' => 'exists:options,id',
        ]);

        // Create new quote
        $quote = Quote::createQuote($validatedData);

        // JSON with the created quote
        return response()->json(['message' => 'Quote created successfully', 'quote' => $quote], 201);
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
        $product = Product::getProductWithOptions($product_id);

        return response()->json($product);
    }
}
