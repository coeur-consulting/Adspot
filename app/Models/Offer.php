<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = ['result','bid_price','user_id','product_id','duration','cart_id','start','end', 'status'];

    public function user(){
        return $this->belongsTo(User::class);

    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
