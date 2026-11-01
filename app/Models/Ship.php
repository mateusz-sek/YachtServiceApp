<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;


class Ship extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'clients_id',
        'image',
        'name'
    ];
    public function ownerShip(){
        return $this->hasOne(Client::class, 'id', 'clients_id');
    }

    public function repairs(){
        return $this->hasMany(Client::class, 'ship_id', 'id',);
    }
}
