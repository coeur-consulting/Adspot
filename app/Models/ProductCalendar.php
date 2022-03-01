<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCalendar extends Model
{
    use HasFactory;
    protected $fillable = ['user','product_id','start_date','end_date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
