<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsSales extends Model
{
    const STATUS_ENABLED = true;
    const STATUS_DISABLED = false;
    protected $table = 'products_sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['*'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];
}
