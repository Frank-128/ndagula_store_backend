<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected  $fillable =['user_id','status'];

   
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_order')->withPivot('colors','size','amount');
    }

    public function payments(){
        return $this->hasOne(Payment::class);
    }
}
