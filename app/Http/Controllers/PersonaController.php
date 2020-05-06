<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;
use App\Auto;
use App\Sede;
use App\Lote;
use App\Manzana;
use App\Vecino;


class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $categorias = Vecino::select('id','dni','apellido_paterno','apellido_materno','nombres','condicion')
                          ->paginate(15);
        }
        else{

            if($criterio == 'nombre'){
                $criterio = 'concat(nombres," ",apellido_paterno," ",apellido_materno)';
              $categorias = Vecino::where(DB::raw($criterio), 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')
                ->paginate(10); 
            }
            if($criterio == 'dni')
            {     


            $categorias = Vecino::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);

            }
        }
        

        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }

     public function indexPago(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');
            $categorias = Vecino::select(DB::raw('concat(nombres," ",apellido_paterno," ",apellido_materno) as nombre,id'))            
            ->get();
        return [
            
            'categorias' => $categorias
        ];
    }

    public function selectSede(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Sede::where('condicion','=','1')
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function listarPdf(){
        $categorias = Categoria::select('nombre','descripcion','condicion')->orderBy('nombre', 'asc')->get();
        $cont=Categoria::count();

        $pdf = \PDF::loadView('pdf.categoriaspdf',['categorias'=>$categorias,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('categorias.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ubicacion = new Vecino();
        $ubicacion->dni = $request->dni;
        $ubicacion->nombres = $request->nombres;
        $ubicacion->apellido_paterno = $request->apellido_paterno;
        $ubicacion->apellido_materno = $request->apellido_materno;
        $ubicacion->condicion = '1';       
        $ubicacion->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Vecino::findOrFail($request->id);
        $categoria->dni = $request->dni;
        $categoria->nombres = $request->nombres;
        $categoria->apellido_paterno = $request->apellido_paterno;
        $categoria->apellido_materno = $request->apellido_materno;
       /*
        if (is_numeric($request->idmanzana) == true) {
            $categoria->idmanzana = $request->idmanzana;
        }
        */
        
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Lote::findOrFail($request->id);
        $categoria->condicion = '0';
        echo ($request->id);
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Lote::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function selectLote($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Lote::where('condicion','=','1')
        ->where('idmanzana','=',$id)
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['lote' => $categorias];
    }
    public function BuscarDNI($dni){
//echo $dni;



 
//OBTENEMOS EL VALOR
//$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;

//$consulta = file_get_html('https://eldni.com/buscar-por-dni?dni='.$dni);
$consulta = HtmlDomParser::file_get_html('https://eldni.com/buscar-por-dni?dni='.$dni);

$datosnombres = array();
foreach($consulta->find('td') as $header) {
 $datosnombres[] = $header->plaintext;
}
//print_r($headlines);
 
 
//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
 
//$partes = explode("|", $consulta);
 
 
$datos = array(
        0 => $dni,
        1 => $datosnombres[0],
        2 => $datosnombres[1],
        3 => $datosnombres[2],
);
 
return ['reniec' => $datos];   
 


}
}

