<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;
use App\Auto;
use App\Sede;
use App\Lote;
use App\Departamento;
use App\Manzana;
use App\Vecino;
use App\Pago;
use App\Recibo;


class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');

            $categorias = Vecino::select(DB::raw('concat(nombres," ",apellido_paterno," ",apellido_materno) as nombre,id'))            
            ->get();
            
        return [
            
            'categorias' => $categorias
        ];
    }

    public function BuscarPersona($id){


         //if (!$request->ajax()) return redirect('/');

         /*$categorias = Recibo::select('vecinos.nombres','vecinos.apellido_paterno','recibos.monto','recibos.fecha_pago')                
                ->join('pagos', 'recibos.idpago', '=', 'pagos.idpago')
                ->join('vecinos', 'vecinos.id', '=', 'pagos.idvecino')
                ->where('pagos.idvecino','=',$id)  
                ->get();

         return ['pago' => $categorias];*/

         $lote = Lote::select('lote_persona.id','lotes.descripcion as lote_descripcion','manzanas.descripcion as manzana_descripcion',
         \DB::raw('(CASE 
         WHEN sectors.descripcion= "QUINTA CASUARINAS" THEN "QC"       
         WHEN sectors.descripcion= "TEXAO" THEN "TEXAO"
         WHEN sectors.descripcion= "LA CASTILLA" THEN "LC"
         WHEN sectors.descripcion= "PIEDRA SANTA" THEN "PS"  
         END) AS sectors_descripcion'))
                 ->join('lote_persona', 'lote_persona.id_lote', '=', 'lotes.id')
                 ->join('vecinos', 'vecinos.id', '=', 'lote_persona.id_persona')
                 ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')
                 ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
                 ->where('vecinos.id','=',$id)->get();



        $departamento = Departamento::select('departamento_persona.id','departamentos.descripcion as departamento_descripcion','lotes.descripcion as lote_descripcion','manzanas.descripcion as manzana_descripcion',
        \DB::raw('(CASE 
        WHEN sectors.descripcion= "QUINTA CASUARINAS" THEN "QC"       
        WHEN sectors.descripcion= "TEXAO" THEN "TEXAO"
        WHEN sectors.descripcion= "LA CASTILLA" THEN "LC"
        WHEN sectors.descripcion= "PIEDRA SANTA" THEN "PS"  
        END) AS sectors_descripcion'))
                ->join('departamento_persona', 'departamento_persona.id_departamento', '=', 'departamentos.id')
                ->join('vecinos', 'vecinos.id', '=', 'departamento_persona.id_persona')
                ->join('lotes', 'lotes.id', '=', 'departamentos.idlote')
                ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
                ->where('vecinos.id','=',$id)->get();

        $auto= Auto::where('autos.id_vecino','=',$id) 
        ->join('vecinos', 'vecinos.id', '=', 'autos.id_vecino')
        ->get();

              
        $categorias= Vecino::with("Pago.Recibo")
        ->where('vecinos.id','=',$id) 
        ->get();
        //dd($categorias);

       
         return ['pago' => $categorias,
         'lote' => $lote,
         'departamento' => $departamento,
         'auto' => $auto];

    }  

    public function Completar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $categoria = Pago::findOrFail($request->id);
        $categoria->estado = $request->estado;
        $categoria->save();
    }

    public function eliminar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        $categoria = Recibo::findOrFail($request->id);
        $categoria->delete();

    }

    public function actualizar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');        
        $categoria = Recibo::findOrFail($request->id);
        $categoria->fecha_pago = $request->fecha_pago;
        $categoria->nro_recibo = $request->nro_recibo;
        $categoria->monto = $request->monto;
        $categoria->save();

    }

    public function store(Request $request)
    {
      
        //if (!$request->ajax()) return redirect('/');
        $id_persona = $request->idpersona;
        $nro_recibo = $request->nro_recibo;
        $monto = $request->monto;
        $fecha_pago = $request->fecha_pago;
        $inicio = $request->periodo_inicio;
        $inicio = date('Y-m', strtotime($inicio));
        $final = $request->periodo_final;
        $final = date('Y-m', strtotime($final));
       
        
        $start    = new DateTime($inicio);
        $start->modify('first day of this month');
        $end      = new DateTime($final);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $periodo =$dt->format("Y-m-d");
            echo $periodo;

            $categoria = Pago::where('idvecino','=',$id_persona)
            ->where('periodo','=',$periodo)
            ->first();;
            
            if (empty($categoria)){

                $ubicacion = new Pago();
                $ubicacion->periodo = $periodo;
                $ubicacion->idvecino = $id_persona;
                $ubicacion->estado =  '1';      
                $ubicacion->save();

             }
            

             $pago = Pago::where('idvecino','=',$id_persona)
             ->where('periodo','=',$periodo)
             ->first();
             
                  $idpago = $pago->idpago; //  $c->detalleIngreso es una colección

                    $ubicacion = new Recibo();
                    $ubicacion->idpago = $idpago;
                    $ubicacion->nro_recibo = $nro_recibo;
                    $ubicacion->monto = $monto;  
                    $ubicacion->fecha_pago = $fecha_pago;      
                    $ubicacion->save();
            
            //model = User::where('votes', '>', 100)->firstOrFail();
            
           /* $categoria = Vecino::findOrFail($request->id)
            ->where('vecinos.id','=',$id) ;
            $categoria->dni = $request->dni;
            $categoria->nombres = $request->nombres;
            $categoria->apellido_paterno = $request->apellido_paterno;
            $categoria->apellido_materno = $request->apellido_materno;
           
            if (is_numeric($request->idmanzana) == true) {
                $categoria->idmanzana = $request->idmanzana;
                
            }

            $categoria->condicion = '1';
            $categoria->save();
            */
            
            
            
        }
        
        
        
        
        /*->where('','=',$id);
        $categoria = Pago::findOrFail($id_persona);
        
        $ubicacion = new Recibo();
        $ubicacion->dni = $request->dni;
        $ubicacion->nombres = $request->nombres;
        $ubicacion->apellido_paterno = $request->apellido_paterno;
        $ubicacion->apellido_materno = $request->apellido_materno;
        $ubicacion->condicion = '1';       
        $ubicacion->save();*/
    }
  
}

