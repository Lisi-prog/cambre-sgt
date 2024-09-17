<!DOCTYPE html>
<html>
<head>
    <title>Correo Programado</title>
</head>
<body>
    <h1>Este es un correo programado</h1>
    <p>¡Hola, {{ $data['name'] }}! Este correo fue enviado automáticamente.</p>
    <p>Mensaje personalizado: {{ $data['message'] }}</p>

    <table>
        <thead style="height:50px;">
            <th class='ml-3 text-center' style="color:#fff;">Proyecto</th>
            <th class='text-center' style="color:#fff;">Horas</th>
            <th class='text-center' style="color:#fff;">Porcentaje</th>
        </thead>
        <tbody >
            @foreach ($data['info'] as $item)
                <tr>
                    <td class='text-center' style="vertical-align: middle;">{{$item->codigo_servicio}}</td>

                    <td class='text-center' style="vertical-align: middle;">{{$item->h_total}}</td>

                    <td class='text-center' style="vertical-align: middle;">{{$item->porcentaje}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
