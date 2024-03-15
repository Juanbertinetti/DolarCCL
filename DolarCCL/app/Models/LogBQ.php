<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBQ extends Model
{
    protected $table = 'indicadores';
    protected $fillable = ['indicador_financiero', 'valor', 'fecha_act', 'fecha_dato', 'api'];
    protected $dates = ['fecha_act', 'fecha_dato'];
}
