<?php
namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InventoryService {
    public function updateStock($data, $userId)
    {
        $product = Product::findOrFail($data['product_id']);

        $quantity = Arr::get($data, 'quantity');
        $type = Arr::get($data, 'type');
        $reason = Arr::get($data, 'reason');
        $notes = Arr::get($data, 'notes');

        if($type == 'out' && $product->quantity_in_stock < $quantity)
        {
            throw new Exception('Not enough stock');
        }

        $netQuantity= 0;
        if($type == 'in')
        {
            $netQuantity = $product->quantity_in_stock + $quantity;
        }elseif($type == 'out')
        {
            $netQuantity = $product->quantity_in_stock - $quantity;
        }else if($type == 'adjustment')
        {
            $netQuantity = $quantity;
        }

        $product->update(['quantity_in_stock' => $netQuantity]);

        StockMovement::create([
            'product_id' => $data['product_id'],
            'user_id' => $userId,
            'type' => $type,
            'quantity' => $quantity,
            'reason' => $reason,
            'reason' => $notes
        ]);

        return $netQuantity;
    }

    public function getLowStockSummary()
    {
        return [
            'total_low_stock' => Product::lowStock()->count(),
            'total_inactive_stock' => Product::where('active', false)->count(),
            'total_stock_value' => Product::sum(DB::raw('price*quantity_in_stock')),
        ];
    }
}
