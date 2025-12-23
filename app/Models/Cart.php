<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        static::creating(function ($cart) {
            // Cek stok produk sebelum menambahkan ke keranjang
            if ($cart->quantity > $cart->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });
        static::updating(function ($cart) {
            // Cek stok produk sebelum memperbarui keranjang
            if ($cart->quantity > $cart->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
