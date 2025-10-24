<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="{{asset('css/Documentos/hoja-de-ruta.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de Ruta</title>
</head>
<body class="page-border">
    <table>
        <tr>
            <td rowspan="2" class="sin-borde">
                <img class= "logo column-2 header-logo" alt="image"  src="{{asset('img/logo-cambre.png') }}">
                {{-- <img src="{{asset('img/logo_cambre.png') }}" class="header-logo"> --}}
            </td>
            <td colspan="3" class="titulo">HOJA DE RUTA DE MECANIZADO</td>
            <td><strong>Rev.:</strong> {{ $revision ?? ''}}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>IN-HDR</strong></td>
            <td><strong>Fecha:</strong> {{ $fecha_carga ?? ''}}</td>
        </tr>
    </table>

    <table style="margin-top:5px;">
        <tr>
            <td class="atributosize"><strong>ID PIEZA:</strong></td>
            <td class="datosEnc" style="width: 300px;">{{ $idPieza ?? ''}}</td>
            <td class="atributosize"><strong>CANT.:</strong></td>
            <td class="" style="width: 50px;">{{ $cant ?? '' }}</td>
        </tr>
        <tr>
            <td class="atributosize"><strong>CONFECCIONÓ:</strong></td>
            <td class="datosEnc">{{$hdr->getResponsable->getEmpleado->nombre_empleado ?? ''}}</td>
            <td class="atributosize"><strong>ID HDR:</strong></td>
            <td>{{ str_pad($hdr->id_hoja_de_ruta, 4, '0', STR_PAD_LEFT) ?? ''}}</td>
        </tr>
        <tr>
            <td class="atributosize"><strong>UBICACIÓN/ES:</strong></td>
            <td class="datosEnc">{{$hdr->ubicacion ?? ''}}</td>
            <td class="atributosize"><strong>ODM:</strong></td>
            <td>{{ $hdr->getOrdMec->id_orden ?? ''}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td class="atributosize"><strong>FECHA:</strong></td>
            <td>{{ $fechaHoy ?? ''}}</td>
        </tr>
    </table>

    <table style="margin-top:10px;">
        <tr class="azul">
            <th>N°</th>
            <th style="width: 190px;">OPERACIÓN</th>
            <th style="width: 150px;">ASIGNADO</th>
            <th style="width: 70px;">MÁQUINA</th>
            <th>MEDIDAS</th>
            <th>HORAS</th>
            <th style="width: 60px;">FECHA</th>
        </tr>
        @foreach ($hdr->getVistaOperacionesHdr->sortBy('numero') as $op)
            <tr>
                <td>{{ $op->numero ?? '-'}}</td>
                <td style="text-align:left;">{{ $op->nombre_operacion ?? '-' }}</td>
                <td style="text-align:left;">{{$op->ultimo_res ?? ''}}</td>
                <td style="text-align:left;">{{$op->codigo_maquinaria ?? ''}}</td>
                <td></td><td></td><td></td>
            </tr>
        @endforeach
        {{-- @for ($i = 0; $i < 7; $i++)
            <tr><td colspan="7" style="height:20px;"></td></tr>
        @endfor --}}
    </table>
    <table class="observaciones">
        <tr>
            <th>OBSERVACIONES</th>
        </tr>
        <tr>
            <td>
                {{-- Podés imprimir texto dinámico si lo tenés --}}
                {{ $hdr->observaciones ?? '' }}
            </td>
        </tr>
    </table>
</body>
</html>
