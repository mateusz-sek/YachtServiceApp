<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'image',
        'city',
        'street',
        'number',
        'phone_number'
    ];
    public function ships(){
        return $this->hasMany(Ship::class,'clients_id', 'id');
    }


    public function getPaymentTime() {
        return Repair::join('ships', 'ships.id', '=', 'repairs.ship_id')
            ->join('clients', 'clients.id', '=', 'ships.clients_id')
            ->where('clients.id', $this->id)
            ->where('payemnt_done', 0)
            ->orderBy('repairs.date_of_payment')
            ->select('date_of_payment')
            ->first();
    }



    public function getSum(){
        return Repair::join('ships', 'ships.id', '=', 'repairs.ship_id')->join('clients', 'clients.id', '=', 'ships.clients_id')
        ->where('clients.id', '=', $this->id)
        ->where('repairs.payemnt_done', '=', 0)
        ->select( Repair::raw('SUM(price) as sum'))->first();
    }
}
