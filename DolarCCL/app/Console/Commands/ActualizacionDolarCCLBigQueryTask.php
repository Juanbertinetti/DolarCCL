<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use App\Models\RegistroTask;
use Illuminate\Console\Command;
use Throwable;

class ActualizacionDolarCCLBigQueryTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ApiController:actualizarBigQuery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizacion del CCL en BigQuery';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        try{
        $apiController = new ApiController();

        $contenido = $apiController->obtenerCotizacion();

        $compra = $contenido['compra'];
        $venta = $contenido['venta'];
        $fechaModificacion = $contenido['fechaActualizacion'];

        $exito = $apiController->updateBigQueryTask($venta, $compra, $fechaModificacion);

        // guardar en tabla local el registro de actualizacion

         return Command::SUCCESS;

        } catch (Throwable $th) {

            $message = $th->getMessage();
            $file = $th->getFile();
            $line = $th->getLine();
            $trace = $th->getTrace();

            // guardamos el log en nuestra base de datos
            // id - message - file - line - trace
//            RegistroTask::create(
//                //
//            );

            return Command::FAILURE;
        }


    }
}
