@extends('layouts.plantilla')
@section('contenido')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <div class="d-flex justify-content-between">
        <h1>Cotizacion Dolar CCL</h1>
        <a class="btn btn-primary" href="/inicio">Cotizacion Actual</a>
        <a class="btn btn-primary" href="/dolar/log/update">Actualizar BD Local</a>
        <form action="/dolar/bigQuery/update" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="compra" value="{{ $dolarArray['compra'] }}">
            <input type="hidden" name="venta" value="{{ $dolarArray['venta'] }}">
            <input type="hidden" name="fechaActualizacion" value="{{ $dolarArray['fechaActualizacion'] }}">
            <button type="submit" class="btn btn-primary">Actualizar BigQuery</button>
        </form>
    </div>
    @if( session('mensaje') )
        <div class="alert alert-{{ session('css') }}">
            {{ session('mensaje') }}
        </div>
    @endif
        <div class="container mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>indicador_financiero</th>
                        <th>valor</th>
                        <th>fecha_act</th>
                        <th>fecha_dato</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{ $row['indicador_financiero']}} </td>
                        <td>{{ $row['valor']}} </td>
                        <td>{{ $row['fecha_act']}} </td>
                        <td>{{ $row['fecha_dato']}} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

@endsection
