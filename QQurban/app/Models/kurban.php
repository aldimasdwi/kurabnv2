<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurban extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->hasOne(order::class);
    }

    public function order_grups()
    {
        return $this->hasMany(order_grup::class, 'id_kurban');
    }
}
