<?php

namespace App\Http\Controllers;

use App\Models\LogBQ;
use Illuminate\Http\Request;
use App\Http\Controllers\BigQueryController;

class LogBQController extends Controller
{
    protected $bigqueryController;

    public function __construct(BigqueryController $bigqueryController)
    {
        $this->bigqueryController = $bigqueryController;
    }

    public function insertarDatosDesdeBigQuery()
    {
        // Obtener los resultados de la consulta de BigQuery
        $resultadosBigQuery = $this->obtenerRegistrosTable();

        // Iterar sobre los resultados y almacenar en la base de datos local
        foreach ($resultadosBigQuery->rows() as $fila) {
            // Crear un nuevo modelo LogBQ
            $logBQ = new LogBQ([
                'indicador_financiero' => $fila['indicador_financiero'],
                'valor' => $fila['valor'],
                'fecha_act' => $fila['fecha_act'],
                'fecha_dato' => $fila['fecha_dato'],
                'api' => $fila['api'],
            ]);

            // Guardar el modelo en la base de datos
            $logBQ->save();
        }
    }


}

