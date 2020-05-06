<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Modelo;
use App\Sede;
use App\Sector;
use App\Manzana;

class ManzanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $categorias = Manzana::select('manzanas.id','manzanas.descripcion','manzanas.condicion','manzanas.idsector','manzanas.comentario','sectors.descripcion as proy_desc','manzanas.id')
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')  
                ->paginate(15);
        }
        else{
            
            $categorias = Manzana::select('manzanas.id','manzanas.descripcion','manzanas.condicion','manzanas.idsector','manzanas.comentario','sectors.descripcion as proy_desc','manzanas.id')
                ->join('sectors', 'sectors.id', '=', 'manzanas.idsector')  
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
            
            //$categorias = Manzana::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
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

    public function selectSector(Request $request){
       // if (!$request->ajax()) return redirect('/');
        $categorias = Sector::where('condicion','=','1')
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['proyectos' => $categorias];
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
        $sede = new Manzana();
        $sede->descripcion = $request->descripcion;
        $sede->comentario = $request->comentario;
        $sede->idsector = $request->idsector;
        $sede->condicion = '1';
        $sede->save();
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
        $categoria = Manzana::findOrFail($request->id);        
        $categoria->descripcion = $request->descripcion;
        $categoria->comentario = $request->comentario;
        $categoria->idsector = $request->idsector;
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Manzana::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Manzana::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function selectManzana($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Manzana::where('condicion','=','1')
        ->where('idsector','=',$id)
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['sede' => $categorias];
    }
    

    
}
