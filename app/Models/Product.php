<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('qty');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
