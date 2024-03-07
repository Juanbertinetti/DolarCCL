<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBQ extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $table = 'cotizacion_ccl';
    public $timestamps = false;
    protected $fillable = [
        'indicador_financiero',
        'valor',
        'fecha_act',
        'fecha_dato',
    ];
}
