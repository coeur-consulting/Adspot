<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'media',
        'location',
        'type',
        'status',
        'price',
        'featured',
        'user_id',
        'category_id',
        'impressions',
        'subcategory_id',
        'dimension',
        'duration',
        'duration_type',
         'start_time',
          'end_time',
        'space_status'

    ];

    protected $casts = [
        'status' => 'boolean',
        'media' => 'array'
    ];
    public function calendar()
    {
        return $this->hasMany(ProductCalendar::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderhistories()
    {
        return $this->belongsTo(OrderHistory::class);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class)->where('result','pending')->with('user')->latest();
    }


}
