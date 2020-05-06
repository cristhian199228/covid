<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Ubicacion;
use App\Sede;
use App\Lote;
use App\Manzana;
use App\Departamento;
use App\DepartamentoPersona;

class DepartamentoController extends Controller
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
            $categorias = Departamento::select('departamentos.id','departamentos.descripcion as desc_dep','lotes.descripcion as desc_lote','manzanas.descripcion as desc_man','sectors.descripcion as desc_sec','departamentos.comentario',
            'departamentos.condicion')
                ->join('lotes', 'lotes.id', '=', 'departamentos.idlote')
                ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')                
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')    
                ->paginate(10);
        }
        else{
            $categorias = Departamento::select('departamentos.id','departamentos.descripcion as desc_dep','lotes.descripcion as desc_lote','manzanas.descripcion as desc_man','sectors.descripcion as desc_sec','departamentos.comentario',
            'departamentos.condicion')
                ->join('lotes', 'lotes.id', '=', 'departamentos.idlote')
                ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')                
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')    
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
            //$categorias = Lote::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
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
        $ubicacion = new Departamento();
        $ubicacion->descripcion= $request->descripcion;
        $ubicacion->comentario = $request->comentario;
        $ubicacion->idlote = $request->idlote;
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
        $categoria = Departamento::findOrFail($request->id);
        $categoria->descripcion = $request->descripcion;
        $categoria->comentario = $request->comentario;
        if (is_numeric($request->idlote) == true) {
            $categoria->idlote = $request->idlote;
        }
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Ubicacion::findOrFail($request->id);
        $categoria->condicion = '0';
        echo ($request->id);
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Ubicacion::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function selectUbicacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Ubicacion::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['ubicacion' => $categorias];
    }

    public function ListarDepaAsignada($id){
            
                 
        // $categorias = Sede::where('condicion','=','1')
        // ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        //('name', 'like', '%' . Input::get('name') . '%')->get();
        //echo $auto;
 
        /*$autos= Auto::where('id_vecino','=',$id)->get();
        return ['auto' => $autos];*/


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
                
                
                return ['departamento' => $departamento];
             
               
     }
    
     public function selectDepartamento($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Departamento::where('condicion','=','1')
        ->where('idlote','=',$id)
        ->select('id','descripcion')
        ->orderBy('descripcion', 'asc')->get();
        return ['departamento' => $categorias];
    }

    public function asignar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $ubicacion = new DepartamentoPersona();
        $ubicacion->id_persona= $request->id_persona;
        $ubicacion->id_departamento = $request->id_departamento;     
        $ubicacion->save();
    }
    

    public function liberar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $lote = DepartamentoPersona::where('id', $request->id)->delete();
        
    }
}
