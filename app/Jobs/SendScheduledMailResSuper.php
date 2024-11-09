<?php

namespace App\Jobs;

use App\Mail\ScheduledMail;
use App\Mail\ScheduleMailResSuper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cambre\Og_organigrama;
use App\Models\Cambre\Empleado;

class SendScheduledMailResSuper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $users;
    
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fechaHoy = date("Y-m-d");
        $fechaHace7Dias = date("Y-m-d", strtotime("-7 days", strtotime($fechaHoy)));

        foreach ($this->users as $user) {
            if (!$user->getEmpleado) {
                continue;
            }

            $empleadoId = $user->getEmpleado->id_empleado;
            $emailSup = $user->getEmpleado->email_empleado;

            // Obtener datos de servicios del usuario
            $datosUsuario = DB::select('CALL ObtenerTotalHorasServicio(?, ?, ?)', [$empleadoId, $fechaHace7Dias, $fechaHoy]);

            
            // Preparar datos para el gráfico del usuario
            $datosGraficoUsuario = $this->prepararDatosGrafico($datosUsuario);

            // Obtener lista de subordinados
            $subordinados = Og_organigrama::where('id_supervisor_directo', $empleadoId)->pluck('id_empleado')->toArray();

            // Obtener datos de subordinados de forma masiva
            $empleados = Empleado::whereIn('id_empleado', $subordinados)->pluck('nombre_empleado', 'id_empleado');
            $datosSubordinados = [];

            foreach ($subordinados as $subId) {
                $datosSub = DB::select('CALL ObtenerTotalHorasServicio(?, ?, ?)', [$subId, $fechaHace7Dias, $fechaHoy]);
                $nombreEmpleado = $empleados[$subId] ?? 'Desconocido';

                // Preparar datos para el gráfico del subordinado
                $datosGraficoSub = $this->prepararDatosGrafico($datosSub);
                $totalHorasSub = isset($datosSub[0]) ? substr($datosSub[0]->total_ac, 0, -3) : '0';

                $datosSubordinados[] = [
                    'name' => $nombreEmpleado,
                    'message' => 'prueba',
                    'info' => $datosSub,
                    'total_horas' => $totalHorasSub,
                    'chart' => $datosGraficoSub['chart_url']
                ];
            }

            // Si no hay datos, enviar correo sin datos
            if (empty($datosUsuario)) {
                $data = [
                    'name' => $user->name,
                    'message' => 'prueba',
                    'fecha_desde' => $fechaHace7Dias,
                    'fecha_hasta' => $fechaHoy,
                    'datos_sub' => $datosSubordinados
                ];
                Mail::to($emailSup)->send(new ScheduleMailResSuper($data, 2));
                continue;
            }

            // Preparar datos para el correo
            $data = [
                'name' => $user->name,
                'message' => 'prueba',
                'info' => $datosUsuario,
                'fecha_desde' => $fechaHace7Dias,
                'fecha_hasta' => $fechaHoy,
                'total_horas' => substr($datosUsuario[0]->total_ac, 0, -3),
                'chart' => $datosGraficoUsuario['chart_url'],
                'datos_sub' => $datosSubordinados
            ];

            // Enviar correo
            Mail::to($emailSup)->send(new ScheduleMailResSuper($data, 1));
        }
    }

    /**
     * Función para preparar datos del gráfico y obtener URL de la imagen.
     */
    private function prepararDatosGrafico($datos)
    {
        $codigo = [];
        $porcentaje = [];

        foreach ($datos as $item) {
            $codigo[] = $item->codigo_servicio;
            $porcentaje[] = $item->porcentaje;
        }

        if (empty($codigo) || empty($porcentaje)) {
            return ['chart_url' => ''];
        }

        $chartData = [
            'type' => 'pie',
            'data' => [
                'labels' => $codigo,
                'datasets' => [['data' => $porcentaje]]
            ],
            'options' => [
                'plugins' => [
                    'datalabels' => [
                        'display' => true,
                        'align' => 'bottom',
                        'backgroundColor' => '#ccc',
                        'borderRadius' => 3,
                        'font' => ['size' => 18],
                    ]
                ]
            ]
        ];

        $chartData = json_encode($chartData);
        $chartURL = "https://quickchart.io/chart?width=600&height=200&c=" . urlencode($chartData);
        
        return ['chart_url' => $chartURL];
    }
}
