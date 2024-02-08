@extends('layouts.plantilla')
@section('contenido')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <h1>Cotizacion Dolar CCL</h1>

    <div class="container mt-5">
        <table class="table">
            <tbody>
            <tr>
                <td>Fecha de actualizacion</td>
                <td>{{$fechaModificacion}}</td>
            </tr>
            <tr>
                <td>Compra</td>
                <td>{{$compra}}</td>
            </tr>
            <tr>
                <td>Venta</td>
                <td>{{$venta}}</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection
