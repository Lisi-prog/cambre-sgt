<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="{{asset('css/Documentos/resumen-semanal.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RESUMEN SEMANAL</title>
</head>
<body>
    <header style="margin-left: -380px; margin-top: -50px;">
        <img class= "logo column-2 header-logo" alt="image"  src="{{asset('img/logo-cambre.png') }}">
        {{-- <img class= "logo" alt="image"  src="{{asset('img/logo_iprodha.jpg') }}" style="width: 260px !important; height:40px; !important"> --}}
    </header>
    {{-- <div class="contenido" style="margin-left: -30px; margin-top: 150px;"> --}}
    <div class="contenido" style="margin-left: -30px;">
        <div class="column-4" style="width: 150px; height: 80% !important; margin-top: 90px;" >
            {{-- <img src="{{'data:image/jpeg;base64,'.$sello}}" width="130" height="60" style="transform: rotate(-15deg);"/> --}}
            {{-- @foreach ($sellos as $sello)
                <img src="{{'data:image/jpeg;base64,'.$sello->imgSello}}" width="{{$sello->ancho}}" height="{{$sello->alto}}" style="transform: rotate(-15deg); margin-bottom: 100px; margin-right: 20px"/>
            @endforeach --}}
        </div>
        <section class="section">
            <div class="section-header">
                <h4 style="text-align: center;">RESUMEN AVANCE DE PROYECTOS</h4>
            </div>
            <div class="section-body" style="margin-right: -30px;">
                @foreach($data['data']['info'] as $item)
                    {{ $item->codigo_servicio }}
                @endforeach
               {{-- <div class="column-4r" style="text-align: right;">
                    <p style="
                    font-family: Verdana, Geneva, sans-serif;
                    font-size: 14px;              /* Equivalente a 10.5pt */
                    text-align: justify;
                    line-height: 1.8;
                    margin: 0;
                  ">-------------Por la presente, el <strong>INSTITUTO PROVINCIAL DE DESARROLLO HABITACIONAL</strong> certifica la Cancelación Total del Saldo de Capital <strong>{{$nom_ad}} – {{$nom_cat}} – {{$esArrMiCasa ? '' : 'B°'}}{{$nom_barrio}}</strong> de la localidad de {{$localidad}}, por el precio de venta <strong>{{$capital}}, (PESOS {{$capital_en_letras}})</strong>, cuyo Titular es <strong>{{$titular}}</strong>, en fecha <strong>{{$fecha_pago_cuota}}</strong>, de conformidad a las normas establecidas en la Ley N° 21.581, modificatorias y Resoluciones Reglamentarias vigentes.</br> A partir de la fecha el INSTITUTO PROVINCIAL DE DESARROLLO HABITACIONAL se aparta y desiste, renunciando a todos los derechos y acciones que le pudieran corresponder, quedando como único responsable de la unidad el Adquirente. <br><br>Posadas, Misiones,  <strong>{{$fechaHoy}}</strong>.-</p>
                  <div class="" style="text-align: right; margin-top: 100px;">
                    <img src="{{'data:image/jpeg;base64,'.$firma['imgSello']}}" width="{{$firma['ancho']}}" height="{{$firma['alto']}}" style=""/>
                  </div>
               </div> --}}
            </div>
        </section>
    </div>
</body>
</html>