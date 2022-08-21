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

        $limit = $request->query('limit');

        // $products = Product::with('category')->get();
        $pagination = Product::paginate(ceil($limit));
        $products = $pagination->items();

        $currentPage = $pagination->currentPage();
        $totalPage = $pagination->lastPage();
        $limitation = $pagination->perPage();

        $paginationRes = [
            'limit' => $limitation,
            'current_page' => $currentPage,
            'total_page' => $totalPage,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $products,
            'pagination' => $paginationRes
        ]);
    }

    public function addToCart(Request $request){
        $apiKey = $request->input('api_key');
        $secretApiKey = 'j%U3Q&Yy&U^$5$hiM76L!92$$A*7@&BQ7!*4^8@v6wbGaw';

        $rules = [
            'api_key' => 'required|string',
            'product_id' => 'required|integer'
        ];

        $data = [
            'api_key' => $request->input('api_key'),
            'product_id' => $request->input('product_id'),
        ];

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

        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $updateField = [
            'is_checkout' => $request->input('is_checkout'),
            'quantity' => $request->input('quantity')
        ];

        $product->update($updateField);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);


    }
}
