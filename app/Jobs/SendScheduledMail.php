<?php

namespace App\Jobs;

use App\Mail\ScheduledMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SendScheduledMail implements ShouldQueue
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
        /* foreach ($this->users as $user) {
            $data = [
                'name' => $user->name,
                'message' => $user->custom_message
            ];
            Mail::to($user->email)->send(new ScheduledMail($data));
        } */

        $codigo = [];
        $porc = [];
        $fechaHoy = date("Y-m-d");
        $fechaHace7Dias = date("Y-m-d", strtotime("-7 days", strtotime($fechaHoy)));

        foreach ($this->users as $user){

            if ($user->getEmpleado) {
                $datos = DB::select('CALL ObtenerTotalHorasServicio(?, ?, ?)', [$user->getEmpleado->id_empleado, $fechaHace7Dias, $fechaHoy]);

                foreach ($datos as $ite) {
                    $codigo[] = $ite->codigo_servicio;
                    $porc[] = $ite->porcentaje;
                }
                $chartData = ['type' =>'pie',
                            'data' => ['labels' => $codigo, 'datasets' => [['data' =>$porc]]],
                            'options' =>  [
                        'plugins' =>  [
                        'datalabels' =>  [
                        'display' =>  true,
                        'align' =>  'bottom',
                        'backgroundColor' =>  '#ccc',
                        'borderRadius' =>  3,
                        'font' =>  [
                        'size' =>  18,
                        ],
                    ],
                    ],
                ]];
                $chartData = json_encode($chartData);
                // return $chartData;
                $chartURL = "https://quickchart.io/chart?width=600&height=200&c=".urlencode($chartData);
                $chartData = file_get_contents($chartURL); 
                $chart = 'data:image/png;base64, '.base64_encode($chartData);

                if ($datos) {
                    $data = [
                        'name' => $user->name,
                        'message' => 'prueba',
                        'info' =>  $datos,
                        'fecha_desde' => $fechaHace7Dias,
                        'fecha_hasta' => $fechaHoy,
                        'total_horas' => substr($datos[0]->total_ac, 0, -3),
                        'chart' => $chartURL
                    ];
                    Mail::to($user->getEmpleado->email_empleado)->send(new ScheduledMail($data, 1));
                    //Mail::to(User::find(2)->getEmpleado->email_empleado)->send(new ScheduledMail($data, 1));
                } else {
                    $data = [
                        'name' => $user->name,
                        'message' => 'prueba',
                        'fecha_desde' => $fechaHace7Dias,
                        'fecha_hasta' => $fechaHoy,
                    ];
                    Mail::to($user->getEmpleado->email_empleado)->send(new ScheduledMail($data, 2));
                    //Mail::to(User::find(2)->getEmpleado->email_empleado)->send(new ScheduledMail($data, 2));
                }
                
                
            }
            
            $codigo = [];
            $porc = [];
        }

        
    
    }
}
