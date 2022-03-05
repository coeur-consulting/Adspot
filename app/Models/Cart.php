<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'price',
        'total',
        'user_id',
        'product_id',
        'duration',
        'type',
        'cart_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function offer()
    {
        return $this->hasOne(Offer::class)->latest();
    }
    public function product()
    {
        return $this->belongsTo(Product::class)->with('category','subcategory');
    }

}
