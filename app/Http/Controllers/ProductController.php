<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getDataProduct(Request $request)
    {
        $apiKey = $request->input('api_key');
        $secretApiKey = 'j%U3Q&Yy&U^$5$hiM76L!92$$A*7@&BQ7!*4^8@v6wbGaw';

        $rules = [
            'api_key' => 'required|string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        if ($apiKey !== $secretApiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'API Key is not valid'
            ], 400);
        }

        $products = Product::with('category')->get();
        // $products = Product::all();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
}
