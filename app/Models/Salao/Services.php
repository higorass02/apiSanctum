<?php

namespace App\Models\Salao;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $fillable = ['*'];
    protected $table = 'services';
    protected $hidden = [];
    protected $casts = [
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
