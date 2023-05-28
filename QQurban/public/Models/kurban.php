<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class kurban extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne(order::class);
    }

    public function order_grup()
    {
        return $this->hasOne(order_grup::class);
    }
   
}
