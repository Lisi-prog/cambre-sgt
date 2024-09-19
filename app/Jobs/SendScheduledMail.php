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
        $us = 18;
        $datos = DB::select('CALL ObtenerTotalHorasServicio(?, 15)',[$us]);

        $codigo = [];
        $porc = [];  

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


        $data = [
            'name' => User::find(2)->name,
            'message' => 'prueba',
            'info' =>  $datos,
            'fecha_desde' => $datos[0]->fecha_desde,
            'fecha_hasta' => $datos[0]->fecha_hasta,
            'total_horas' => substr($datos[0]->total_ac, 0, -3),
            'chart' => $chartURL
        ];

        Mail::to('lisandrosilvero@gmail.com')->send(new ScheduledMail($data));
    }
}
