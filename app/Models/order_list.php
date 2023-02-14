<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_list extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','total','quantity','order_code'];
}
