@extends('layouts.app')
@section('titulo', 'Informes')

@section('content')
<style>

</style>
<section class="section">
    <div class="d-flex section-header justify-content-center">
        <div class="d-flex flex-row col-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 my-auto">
                <h4 class="titulo page__heading my-auto">Informes</h5>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 mx-4">
            </div>
        </div>
    </div>
    {{-- @include('layouts.modal.mensajes', ['modo' => 'Agregar']) --}}
    <div class="section-body">   
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => 'informes.store', 'method' => 'POST', 'class' => 'formulario', 'id' => 'formulario_informe']) !!}
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('informe', 'Informe:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('id_informe', $tipos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_informe',
                                            'required'
                                        ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fec_desde', 'Fecha Desde:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::date('fecha_desde', \Carbon\Carbon::now(), [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'input-fec_ini',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('fec_hasta', 'Fecha Hasta:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::date('fecha_hasta', \Carbon\Carbon::now(), [
                                        'min' => '2023-01-01',
                                        'max' => \Carbon\Carbon::now()->year . '-12',
                                        'id' => 'input-fec_ini',
                                        'class' => 'form-control',
                                        'required'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('tecni', 'Tecnico:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('tecni', $tecnicos, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_tecni',
                                        ]) !!}
                                </div>
                            </div>
                            @role('SUPERVISOR')
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('supervi', 'Supervisor:', ['class' => 'control-label fs-7', 'style' => 'white-space: nowrap; ']) !!}
                                    {!! Form::select('supervi', $supervisores, null, [
                                            'placeholder' => 'Seleccionar',
                                            'class' => 'form-select',
                                            'id' => 'id_supervi'
                                        ]) !!}
                                </div>
                            </div>
                            @endrole
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 my-auto">
                                <div class="form-group my-auto">
                                    {!! Form::submit('Generar', ['class' => 'btn btn-success w-100']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="ver-informes" hidden>
                <div class="card">
                    <div class="card-body">
                        @include('layouts.loanding')
                        <div class="row mb-2">
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <button class="btn btn-warning w-100">PDF</button>
                            </div>
                        </div>
                        <div class="row" id="vista-grafico">

                        </div>
                        <div class="row mt-3" id="avance-subor">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            document.getElementById("formulario_informe").addEventListener("submit", function(e) {
                e.preventDefault();

                var url_php = $(this).attr("action"); 
                var type_method = $(this).attr("method"); 
                var form_data = $(this).serialize();
            
                $("#loading").show();
                $.ajax({
                    type: type_method,
                    url: url_php,
                    data: form_data,
                    timeout: 60000, // 60 segundos de espera
                    success: function(res) {
                        console.log(res);
                        document.getElementById('ver-informes').hidden = false;
                        let trProyAv = '';
                        let trEmpAv = '';
                        let avPorSubord = '';
                        console.log(res);
                        let grafico = `<div class="" style="width: 30vw; height: 20vw; position: relative;">
                                            <img src="${res.data.chart}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                        </div>`;

                        res.data.info
                        .sort((a, b) => b.porcentaje - a.porcentaje)
                        .forEach(e => {
                            trProyAv += `<tr style="">
                                            <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.codigo_servicio}</td>
                                                                                
                                            <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.h_total}</td>
                                                                                
                                            <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.porcentaje}%</td>
                                                                                
                                        </tr>`;
                        });

                        res.data.datos_sub
                        .sort((a, b) => a.name.localeCompare(b.name))
                        .forEach(e => {
                            let trInfoSub = '';

                        trEmpAv += `<tr style="">
                                        <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.name}</td>
                                                                            
                                        <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${e.total_horas}</td>
                                                                            
                                    </tr>`;
                        if (Number(e.total_horas) != 0) {
                            

                            e.info.forEach( i => {
                                    trInfoSub += `<tr style="">
                                            <td class='text-end' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.codigo_servicio}</td>
                                                                                
                                            <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.h_total}</td>

                                            <td class='text-center' style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">${i.porcentaje}%</td>
                                                                                
                                        </tr>`
                            })
                            
                            avPorSubord += `<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row border">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <label class="control-label fs-7" style="white-space: nowrap; ">${e.name}</label>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="" style="width: 18vw; margin: auto;">
                                                            <img src="${e.chart}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <table style="width: 100%">
                                                            <thead style="">
                                                                <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Proyecto</th>
                                                                <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Horas</th>
                                                                <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0;">Porcentaje</th>
                                                            </thead>
                                                            <tbody>
                                                                ${trInfoSub}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                        <h5>Total Hs: <strong>${e.total_horas}</strong></h5>
                                                    </div>
                                                </div>
                                            </div>`;
                        }
                        });

                        document.getElementById('vista-grafico').innerHTML = `
                                                                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center border border-secondary">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                                                            <h3>Avance Supervisor</h3>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                            <label class="control-label fs-7" style="white-space: nowrap; ">Grafico:</label>
                                                                                            ${grafico}
                                                                                        </div>
                                                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                                            <label class="control-label fs-7" style="white-space: nowrap; ">Avance Proyectos:</label>
                                                                                            <table>
                                                                                                <thead style="height:50px;">
                                                                                                    <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Proyecto</th>
                                                                                                    <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                                                                                                    <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Porcentaje</th>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    ${trProyAv}
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row mt-4">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                                                            <h3>Total Hs: ${res.data.total_horas}</h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border border-start-0 border-secondary">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-2">
                                                                                            <h3>Avance Subordinados</h3>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                                            <label class="control-label fs-7" style="white-space: nowrap; ">Avance Subordinados:</label>
                                                                                            <table>
                                                                                                <thead style="height:50px;">
                                                                                                    <th class='ml-3 text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Empleado</th>
                                                                                                    <th class='text-center' style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    ${trEmpAv}
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            `;

                        document.getElementById('avance-subor').innerHTML = avPorSubord;                                                        
                    },
                    complete: function() {
                        $("#loading").hide(); 
                    },
                    error: function(jqXHR, textStatus) {
                        $("#loading").hide();
                        if (textStatus === "timeout") {
                            alert("La generacion del informe tardo demaciado.");
                        } else {
                            alert("Error en la solicitud: " + textStatus);
                        }
                    }
                });
            });
        });
    </script>
</section>

@endsection
