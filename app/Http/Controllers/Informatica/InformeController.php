<?php

namespace App\Http\Controllers\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use \PDF;

use App\Models\User;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Og_organigrama;
// use App\Models\Cambre\Sector;
// use App\Models\Cambre\Puesto_empleado;
// use App\Models\Cambre\Em_not_x_empleado;
// use App\Models\Cambre\Em_notificacion;
// use App\Models\Cambre\Og_organigrama;
// use App\Models\Cambre\Maquinaria;
// use App\Models\Cambre\Emp_x_maq;

class InformeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $tipos = [
            1 => "Resumen Semanal"
        ];

        $supervisores = $this->obtenerSupervisores();
        $tecnicos = $this->obtenerEmpleadosActivos()->pluck('nombre_empleado', 'id_empleado');
        return view('Informatica.Informes.index',compact('tipos', 'supervisores', 'tecnicos'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $opcion = $request->input('id_informe');
        $fechaIni = $request->input('fecha_desde');
        $fechaFin = $request->input('fecha_hasta');
        $supervisor = $request->input('supervi');

        switch ($opcion) {
            case 1:
                return $this->generarResumenSemanal($fechaIni, $fechaFin, $supervisor);
                break;
        }
        return $request;                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
                                
    }
    
    public function destroy($id)
    {
                      
    }

    public function generarResumenSemanal($fechaIni, $fechaFin, $supervisor)
    {
        $fechaHoy = $fechaFin;
        $fechaHace7Dias = $fechaIni;

        $empleadoId = $supervisor;

        // Obtener datos de servicios del usuario
        $datosUsuario = DB::select('CALL ObtenerTotalHorasServicio(?, ?, ?)', [$empleadoId, $fechaHace7Dias, $fechaHoy]);

        if (count($datosUsuario) != 0) {
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
                $datosGraficoSub = $this->prepararDatosGraficoSubordinados($datosSub);
                $totalHorasSub = isset($datosSub[0]) ? substr($datosSub[0]->total_ac, 0, -3) : '0';

                $base64Sub = null;

                if (!empty($datosGraficoSub['chart_url'])) {
                    $imageSub = file_get_contents($datosGraficoSub['chart_url']);
                    $base64Sub = 'data:image/png;base64,' . base64_encode($imageSub);
                }
                $datosSubordinados[] = [
                    'name' => $nombreEmpleado,
                    'info' => $datosSub,
                    'total_horas' => $totalHorasSub,
                    'chart' => $datosGraficoSub['chart_url'],
                    'chart_base64' => $base64Sub,
                ];
            }

            $image = file_get_contents($datosGraficoUsuario['chart_url']);
            $base64 = 'data:image/png;base64,' . base64_encode($image);

            // Preparar datos para el correo
            $data = [
                'empleadoId' => $empleadoId,
                'info' => $datosUsuario,
                'fecha_desde' => $fechaHace7Dias,
                'fecha_hasta' => $fechaHoy,
                'total_horas' => substr($datosUsuario[0]->total_ac, 0, -3),
                'chart' => $datosGraficoUsuario['chart_url'],
                'chart_base64' => $base64,
                'datos_sub' => $datosSubordinados
            ];

            return [
                'data' => $data,
                'vacio' => 0
            ];
        } else {
            return [
                'vacio' => 1
            ];
        }
    }

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
        $chartURL = "https://quickchart.io/chart?width=600&height=400&c=" . urlencode($chartData);
        
        return ['chart_url' => $chartURL];
    }

    private function prepararDatosGraficoSubordinados($datos)
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
        $chartURL = "https://quickchart.io/chart?width=600&height=600&c=" . urlencode($chartData);
        
        return ['chart_url' => $chartURL];
    }

    public function obtenerSupervisores(){
        $usuariosSupervisor = User::role('SUPERVISOR')->pluck('id')->toArray();
        return Empleado::whereIn('user_id', $usuariosSupervisor)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
    }

    public function obtenerEmpleadosActivos(){
        return Empleado::orderBy('nombre_empleado')->activo()->get();
    }

    public function resumenSemanalPdf(Request $request){
        $pdf = app('dompdf.wrapper');
        // return $request;
        $fechaIni = $request->input('fec_ini');
        $fechaFin = $request->input('fec_fin');
        $supervisor = $request->input('id_tecnico');

        $data = $this->generarResumenSemanal($fechaIni, $fechaFin, $supervisor);

        return $pdf->loadView('Informatica.Informes.documentos.resumen-semanal-pdf',[
                                    'data' => $data,
                                    'fechaIni' => $fechaIni,
                                    'fechaFin' => $fechaFin])
                                    ->setPaper('a4', 'portrait')
                                    ->stream('resumenSemanal.pdf');  
    }
}