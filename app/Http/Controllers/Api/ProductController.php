<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InventoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $inventoryService;
    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $allProducts = product::with('category')->get();

        return response()->json($allProducts);
    }

    public function showProduct(int $id)
    {
        $product =  Product::with(['category'])->findOrFail($id);

        return response()->json($product);
    }

    public function store(Request  $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|gt:0',
            'cost' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'supplier_name' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'errors' => $validator->errors()]);
        }
        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => [
                'sometimes',
                'max:255',
                Rule::unique('products')->ignore($product->id)
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|gt:0',
            'cost' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'supplier_name' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'errors' => $validator->errors()]);
        }
        $product = $product->update($request->all());

        return response()->json($product);
    }


    public function updateStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'errors' => $validator->errors()]);
        }

        $userId = auth()->id() ?? 1;

        try{
            $data = $request->all();
            $data['product_id'] = $id;
            $newStock = $this->inventoryService->updateStock($data, $userId);
            return response()->json([
                'message' => 'stock updated successfully',
                'new_stock_level' => $newStock
            ]);
        } catch(Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getProductWithMinimumLevel()
    {
        $product = Product::lowStock()->with('category')->get();

        return response()->json($product);
    }
}
