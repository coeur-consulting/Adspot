<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = ['bid','user_id','product_id', 'quantity'];

    public function user(){
        return $this->hasOne(User::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
