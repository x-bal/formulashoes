<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
