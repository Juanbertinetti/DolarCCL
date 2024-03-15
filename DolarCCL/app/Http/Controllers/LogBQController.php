<?php

namespace App\Http\Controllers;

use App\Models\LogBQ;
use Google\Cloud\BigQuery\QueryResults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Table;

class LogBQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request) :RedirectResponse
    {
        //
        //
        $venta = $request->venta;
        $compra = $request->compra;
        $fechaModificacion = Carbon::parse($request->fechaActualizacion)->toDateTimeString();

        $data = [
            [
                'indicador_financiero' => "CCL-Venta",

                'valor' => $venta,
                'fecha_act' => now(),
                'fecha_dato' => $fechaModificacion,
            ],
            [
                'indicador_financiero' => "CCL-Compra",
                'valor' => $compra,
                'fecha_act' => now(),
                'fecha_dato' => $fechaModificacion,
            ]
        ];
        try {
            foreach ($data as $item) {
                LogBQ::create($item);
            }

            return redirect('/dolar/bigQuery/index')
                ->with([
                    'mensaje' => 'Registros agregados correctamente.',
                    'css' => 'success'
                ]);
        } catch (\Throwable $th) {

            return redirect('/dolar/bigQuery/index')
                ->with([
                    'mensaje' => 'No se pudieron agregar los registros.',
                    'css' => 'danger'
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogBQ  $logBQ
     * @return \Illuminate\Http\Response
     */
    public function show(LogBQ $logBQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogBQ  $logBQ
     * @return \Illuminate\Http\Response
     */
    public function edit(LogBQ $logBQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogBQ  $logBQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogBQ $logBQ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogBQ  $logBQ
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogBQ $logBQ)
    {
        //
    }
}
