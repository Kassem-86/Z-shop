<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $guarded =[];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
{
    return $this->hasMany(Cart::class);
}

public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}


}
