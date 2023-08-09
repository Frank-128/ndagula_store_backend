<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $casts = [
        'colors'=>'json',
        'category'=>'json',
        'size'=>'json'
    ];
    protected $fillable = ['name','category','price','amount','rating','image','size','colors'];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function orders(){
        return $this->hasMany(Order::class)->withPivot('colors','size','amount');
    }
}
