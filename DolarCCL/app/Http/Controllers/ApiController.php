<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\QueryResults;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $dolarArray = $this->obtenerCotizacion();

        // Acceder a la información necesaria
        $compra = $dolarArray['compra'];
        $venta = $dolarArray['venta'];

        // Obtener la fecha de actualización en formato Carbon con UTC-0
        $fechaModificacionUTC = Carbon::parse($dolarArray['fechaActualizacion'], 'UTC');

        // Ajustar el huso horario a UTC-3
        $fechaModificacion = $fechaModificacionUTC->setTimezone('America/Argentina/Buenos_Aires');

        return view('inicio', [
            'compra' => $compra,
            'venta' => $venta,
            'fechaModificacion' => $fechaModificacion,
        ]);
    }




    public function indexBigQuery()
    {
        $credentialsPath = __DIR__ . '/../../../googleCloud.json';
        $projectId = 'bigquerytp3d';
        $dataset = 'control_precios';
        $table = 'data_financiera';

        $bigQuery = new BigQueryController($credentialsPath, $projectId, $dataset, $table);
        $results = $bigQuery->obtenerRegistrosTable()->rows();
        $dolarArray = $this->obtenerCotizacion();

        return view('dolarBigQuery', [
            'rows' => $results,
            'dolarArray' => $dolarArray,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function obtenerCotizacion() : array
    {
        // Obtener datos de la API
        $dolarData = file_get_contents("https://dolarapi.com/v1/dolares/contadoconliqui");

        // Decodificar el JSON en un array asociativo

        // AGREGAR VALIDACION
        return json_decode($dolarData, true);
    }

    public function conectarBigQuery()
    {
        $credentialsPath = __DIR__ . '/../../../googleCloud.json';
        $projectId = 'bigquerytp3d';
        $dataset = 'control_precios';
        $table = 'data_financiera';

        $client = new BigQueryClient([
            'proyectId' => $projectId,
            'keyFilePath' => $credentialsPath,
        ]);

        $dataset = $client->dataset($dataset);
        $table = $dataset->table($table);

        $query = $client->query(
            'SELECT * FROM `bigquerytp3d.control_precios.data_financiera` ORDER BY fecha_act DESC LIMIT 1000'
        );

        $results = $client->runQuery($query);

        foreach($results->rows() as $row)
        {
            echo $row['indicador_financiero'] . "<br>";
        }
    }

        public function updateBigQuery(Request $request)
        {
            $venta = $request->venta;
            $compra = $request->compra;
            $fechaModificacion = $request->fechaActualizacion;

            ////////////////////
            /// CONEXION CON BIGQUERY
            $credentialsPath = __DIR__ . '/../../../googleCloud.json';
            $projectId = 'bigquerytp3d';
            $dataset = 'control_precios';
            $table = 'data_financiera';

            $bigQuery = new BigQueryController($credentialsPath, $projectId, $dataset, $table);

            $data = [
                [
                    'data' => [
                        'indicador_financiero' => "CCL-Venta",
                        'valor' => $venta,
                        'fecha_act' => Carbon::now()->timestamp,
                        'fecha_dato' => $fechaModificacion,
                    ]
                ],
                [
                    'data' => [
                        'indicador_financiero' => "CCL-Compra",
                        'valor' => $compra,
                        'fecha_act' => Carbon::now()->timestamp,
                        'fecha_dato' => $fechaModificacion,
                    ]
                ]
            ];

            $insertadasCorrectamente = $bigQuery->insertarFilaTable($data)['success'];

            if($insertadasCorrectamente){
                return redirect('/dolar/bigQuery/index')
                    ->with([
                        'css' => 'success',
                        'mensaje' => 'Se ha enviado la actualizacion',
                    ]);
            } else {
                return redirect('/dolar/bigQuery/index')
                    ->with([
                        'css' => 'danger',
                        'mensaje' => 'No se pudo enviar la actualizacion',
                    ]);
            }
        }
}
