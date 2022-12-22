<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    const STATUS_ENABLED = true;
    const STATUS_DISABLED = false;
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
    protected $casts = [
        'status' => 'boolean',
        'spotlight' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_product', 'id');
    }
}
