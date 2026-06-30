<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'operator_id',
        'petition',
        'destination',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
