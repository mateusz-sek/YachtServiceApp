<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Repair extends Model
{
    use HasFactory;


    protected $fillable = [
        'ship_id',
        'price',
        'date_of_payment',
        'payemnt_done',
        'desc',
        'pay_date'
    ];



    public function ship(){
        return $this->hasOne(Ship::class, 'id', 'ship_id');
    }

    protected function getDiffDataAttribute(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $paymentDate = Carbon::parse($attributes['date_of_payment']);
                $now = Carbon::today();

                return $now->diffInDays($paymentDate, false); 
            },
        );
    }
}




