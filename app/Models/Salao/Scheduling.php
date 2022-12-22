<?php

namespace App\Models\Salao;

use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $fillable = ['*'];
    protected $table = 'scheduling';
    protected $hidden = [];
    protected $casts = [
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function Cliente()
    {
        return $this->hasMany(Cliente::class, 'id', 'id_cliente');
    }

    public function Services()
    {
        return $this->hasMany(Services::class, 'id', 'idServices');
    }
}
