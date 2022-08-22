<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyCart extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'my_carts';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    // satu cart punya banyak products

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('id', 'ASC');
    }
}
