<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $guarded = [];


    protected $primaryKey = 'idpago';

    public function Vecino() {
        return $this->BelongsTo('App\Vecino','idvecino');
    }

    public function Recibo(){
        return $this->hasMany('App\Recibo','idpago','idpago');
    }
}
