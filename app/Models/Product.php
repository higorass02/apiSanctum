<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_ENABLED = true;
    const STATUS_DISABLED = false;

    const TYPE_CAPACITY_WEIGHT = 0;
    const STATUS_DISABLED_SIZE = 1;
    const STATUS_DISABLED_VOLUME = 3;

    const MAX_STARS = 5;

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
