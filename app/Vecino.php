<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vecino extends Model
{
    protected $guarded = [];

    public function Pago() {
                               return $this->hasMany('App\Pago','idvecino', 'id');
                }
}
