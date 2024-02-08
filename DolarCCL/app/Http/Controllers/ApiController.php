<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Obtener datos de la API
        $dolarData = file_get_contents("https://dolarapi.com/v1/dolares/contadoconliqui");

        // Decodificar el JSON en un array asociativo
        $dolarArray = json_decode($dolarData, true);

        // Verificar si la decodificación fue exitosa y si la clave 'fechaActualizacion' existe
        if ($dolarArray && isset($dolarArray['compra'], $dolarArray['venta'], $dolarArray['fechaActualizacion'])) {
            // Acceder a la información necesaria
            $compra = $dolarArray['compra'];
            $venta = $dolarArray['venta'];

            // Obtener la fecha de actualización en formato Carbon con UTC-0
            $fechaModificacionUTC = Carbon::parse($dolarArray['fechaActualizacion'], 'UTC');

            // Ajustar el huso horario a UTC-3
            $fechaModificacion = $fechaModificacionUTC->setTimezone('America/Argentina/Buenos_Aires');

            return view('inicio' , compact('compra', 'venta', 'fechaModificacion'));
        } else {
            // Manejar el caso en que la decodificación falle o la clave no exista
            return null;
        }

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
}
