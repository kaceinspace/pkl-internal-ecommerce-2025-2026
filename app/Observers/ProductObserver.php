<?php
namespace App\Observers;

use App\Models\Product;
use function Spatie\Activitylog\activity;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function created(Product $product): void
    {
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');

        if (auth()->check()) {
            activity()
                ->performedOn($product)
                ->causedBy(auth()->user())
                ->withProperties([
                    'product_id' => $product->id,
                    'name'       => $product->name,
                ])
                ->log('Produk baru dibuat');
        }
    }

    public function updated(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');

        if ($product->isDirty('category_id')) {
            Cache::forget('category_' . $product->getOriginal('category_id') . '_products');
            Cache::forget('category_' . $product->category_id . '_products');
        }
    }

    public function deleted(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');
    }
}
