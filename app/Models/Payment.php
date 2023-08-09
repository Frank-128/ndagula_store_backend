<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','total_amount','total_cost'];

    public function orders(){
        return $this->belongsTo(Order::class);
    }
}
