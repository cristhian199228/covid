<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ubicacion;
use App\Sede;
use App\Lote;
use App\Manzana;
use App\LotePersona;

class LoteController extends Controller
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
            $categorias = Lote::select('sectors.id as idsector','lotes.id','lotes.comentario','lotes.descripcion','lotes.condicion','manzanas.descripcion as manzana_desc','sectors.descripcion as sectors_desc','lotes.idmanzana')
                ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
                ->orderBy('sectors.descripcion','asc','manzanas.descripcion', 'asc')    
                ->paginate(15);
        }
        else{

            $categorias = Lote::select('sectors.id as idsector','lotes.id','lotes.comentario','lotes.descripcion','lotes.condicion','manzanas.descripcion as manzana_desc','sectors.descripcion as sectors_desc','lotes.idmanzana')
                ->join('manzanas', 'manzanas.id', '=', 'lotes.idmanzana')
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
                
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
        $ubicacion = new Lote();
        $ubicacion->descripcion= $request->nombre;
        $ubicacion->comentario = $request->descripcion;
        $ubicacion->idmanzana = $request->idmanzana;
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
        $categoria = Lote::findOrFail($request->id);
        $categoria->descripcion = $request->descripcion;
        $categoria->comentario = $request->comentario;
        if (is_numeric($request->idmanzana) == true) {
            $categoria->idmanzana = $request->idmanzana;
        }
        
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

    public function ListarLoteAsignada($id){
            


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
                
                
                return ['lote' => $lote];
     }


     public function asignar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $ubicacion = new LotePersona();
        $ubicacion->id_persona= $request->id_persona;
        $ubicacion->id_lote = $request->id_lote;     
        $ubicacion->save();
    }
    

    public function liberar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $lote = LotePersona::where('id', $request->id)->delete();
        
    }
    
}
