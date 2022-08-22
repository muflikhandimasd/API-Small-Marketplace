<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MyCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $apiKey = $request->input('api_key');
        $secretApiKey = 'j%U3Q&Yy&U^$5$hiM76L!92$$A*7@&BQ7!*4^8@v6wbGaw';

        $rules = [
            'api_key' => 'required|string',
            'category_id' => 'required|integer',
            'product_name' => 'required|string',
            'product_price' => 'required|integer',
            'city' => 'required|string',
            'product_image' => 'required|string',
            'seller_name' => 'required|string',
            'is_halal' => 'integer',
            'is_ready' => 'integer',
            'is_ready' => 'integer',
            'is_new' => 'integer',
            'is_checkout' => 'integer',
            'quantity' => 'integer',
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

        $createField = [
            'category_id' => $request->input('category_id'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'city' => $request->input('city'),
            'product_image' => $request->input('product_image'),
            'seller_name' => $request->input('seller_name'),
            'is_halal' => $request->input('is_halal'),
            'is_ready' => $request->input('is_ready'),
            'is_new' => $request->input('is_new'),
            'is_checkout' => $request->input('is_checkout'),
            'quantity' => $request->input('quantity'),
            'weight' => $request->input('weight')
        ];

        $categoryId =  $request->input('category_id');
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'category not found'
            ]);
        }

        $product = Product::create($createField);
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }
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
        // $pagination = Product::paginate(ceil($limit));
        $paginator = Product::where('is_checkout', '=', 0)->paginate(ceil($limit));
        $products = $paginator->items();

        $currentPage = $paginator->currentPage();
        $totalPage = $paginator->lastPage();
        $limitation = $paginator->perPage();
        $itemCount = $paginator->total();

        $paginationRes = [
            'limit' => $limitation,
            'current_page' => $currentPage,
            'total_page' => $totalPage,
            'item_count' => $itemCount
        ];

        return response()->json([
            'status' => 'success',
            'data' => $products,
            'pagination' => $paginationRes
        ]);
    }

    public function addToCart(Request $request)
    {
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

        $createMyCart = [
            'product_id' => $request->input('product_id')
        ];

        $isCheckOut =  $request->input('is_checkout');
        $product->update($updateField);

        if ($isCheckOut === 1) {
            $myCart = MyCart::create($createMyCart);
            return response()->json([
                'status' => 'success',
                'data' => $product,
                'data_cart' => $myCart
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }
}
