<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];
    protected $casts = [
        'quantity' => 'integer',
    ];
    // ==================== RELATIONSHIPS ====================
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== ACCESSORS ====================
    public function getTotalPriceAttribute()
    {
        return $this->product->discount_price * $this->quantity;
    }
    public function getTotalWeightAttribute()
    {
        return $this->product->weight * $this->quantity;
    }
    // ==================== BOOT ====================
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cartItem) {
            // Cek stok produk sebelum menambahkan ke item keranjang
            if ($cartItem->quantity > $cartItem->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });
        static::updating(function ($cartItem) {
            // Cek stok produk sebelum memperbarui item keranjang
            if ($cartItem->quantity > $cartItem->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });
    }

}
