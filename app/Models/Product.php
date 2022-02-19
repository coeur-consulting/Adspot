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
        'available',
        'location',
        'type',
        'status',
        'price',
        'start',
        'end',
        'other',
        'user_id',
        'category_id',
        'featured',
        'subcategory_id'

    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    protected $casts = [
        'images' => 'array'
    ];
}
