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
<body class="page-border">
    <table>
        <tr>
            <td rowspan="2" class="sin-borde">
                <img class= "logo column-2 header-logo" alt="image"  src="{{asset('img/logo-cambre.png') }}">
            </td>
            <td colspan="3" class="titulo">RESUMEN SEMANAL</td>
        </tr>
        <tr>
            <td colspan="3"><strong>PERIODO: {{ $fechaIni ?? '-'}} al {{$fechaFin ?? '-'}}</strong></td>
        </tr>
    </table>

    <table class="observaciones">
        <tr>
            <th colspan="2">AVANCE SUPERVISOR</th>
        </tr>
        <tr>
            <td>Grafico:</td>
            <td>Avances Proyectos:</td>
        </tr>
        <tr>
            <td>
                <div class="" style="width: 300px; height: 200px; position: relative;">
                    <img src="{{ $data['data']['chart_base64'] }}" style="width: 100%; height: auto;">
                </div>
            </td>
            <td style="width: 400px !important;">
                <table>
                    <thead>
                        <tr>
                            <th class="ml-3 text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Proyecto</th>
                            <th class="text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                            <th class="text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(collect($data['data']['info'])->sortByDesc('porcentaje') as $item)
                            <tr style="">
                                <td class="text-end" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%; text-align: right;">{{$item->codigo_servicio}}</td>
                                                                    
                                <td class="text-center" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">{{$item->h_total}}</td>
                                                                    
                                <td class="text-center" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">{{$item->porcentaje}}%</td>
                                                                    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <table class="observaciones" style="page-break-inside: avoid;">
        <tr>
            <th colspan="2">AVANCE SUBORDINADOS</th>
        </tr>
        <tr>
            <td>Avances Proyectos:</td>
            <td>Graficos:</td>
        </tr>
        <tr>
            <td style="width: 400px !important;">
                <table>
                    <thead>
                        <tr>
                            <th class="ml-3 text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Empleado</th>
                            <th class="text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(collect($data['data']['datos_sub'])->sortByDesc('total_horas') as $sub)
                            <tr style="">
                                <td class="text-end" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%; text-align: right;">{{ $sub['name'] }}</td>
                                                                    
                                <td class="text-center" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">{{ $sub['total_horas'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td>
                <div class="" style="width: 300px; height: 200px; position: relative;">
                    <img src="{{ $data['data']['chart_base64'] }}" style="width: 100%; height: auto;">
                </div>
            </td>
        </tr>
    </table>

    @foreach (collect($data['data']['datos_sub'])->sortByDesc('total_horas') as $sub)
        @if ($sub['total_horas'] != 0)
            <table class="observaciones" style="page-break-inside: avoid;">
                <tr>
                    <th colspan="2">{{ $sub['name'] }}</th>
                </tr>
                <tr>
                    <td>Avances Proyectos:</td>
                    <td>Graficos:</td>
                </tr>
                <tr style="">
                    <td style="">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ml-3 text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Proyecto</th>
                                    <th class="text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Horas</th>
                                    <th class="text-center" style="color:#000; border: 1px solid #000; border-spacing: 0; width: 25%;">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(collect($sub['info'])->sortByDesc('porcentaje') as $item)
                                    <tr style="">
                                        <td class="text-end" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%; text-align: right;">{{$item->codigo_servicio}}</td>
                                                                            
                                        <td class="text-center" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">{{$item->h_total}}</td>
                                                                            
                                        <td class="text-center" style="vertical-align: middle; border: 1px solid #000; border-spacing: 0; width: 25%;">{{$item->porcentaje}}%</td>                                         
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan=3 style="vertical-align: middle;">Total Hs: <strong>{{ $sub['total_horas'] }}</strong></td>
                                    </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 100px; text-align: center;">
                        <div style="width: 200px; height: 200px; overflow: hidden; position: relative;">
                            <img src="{{ $sub['chart_base64'] }}" style="width: 100%; height: auto;">
                        </div>
                    </td>
                </tr>
            </table>
        @endif
    @endforeach
</body>
</html>
