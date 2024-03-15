<?php

namespace App\Console\Commands;
use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;

class ActualizacionDBBigQueryTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ApiController:ActualizarBigQuery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar bigquery automatico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
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
