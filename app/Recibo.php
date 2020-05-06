<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'idrecibo';

    public function Pago() {
        return $this->BelongsTo('App\Pago','idpago');
    }
}
