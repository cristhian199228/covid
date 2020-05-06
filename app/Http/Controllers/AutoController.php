<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Auto;
use App\Sede;
use App\Lote;
use App\Manzana;
use App\Vecino;

class AutoController extends Controller
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
            $categorias = Auto::select('autos.id','autos.placa','autos.marca','autos.modelo','autos.color','autos.serie','autos.condicion')
                          ->paginate(15);
        }
        else{
            $categorias = Auto::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
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
        $ubicacion = new Auto();
        $ubicacion->placa = $request->placa;
        $ubicacion->marca = $request->marca;
        $ubicacion->modelo = $request->modelo;
        $ubicacion->color = $request->color;
        $ubicacion->serie = $request->serie;
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
        $categoria = Auto::findOrFail($request->id);
        $categoria->placa = $request->placa;
        $categoria->marca = $request->marca;
        $categoria->modelo = $request->modelo;
        $categoria->color = $request->color;
        $categoria->serie = $request->serie;
        
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

    public function androidApp($id){
            
                 
        $autos= Auto::find(4)
        ->leftjoin('vecinos', 'vecinos.id', '=', 'autos.id_vecino');
        return response()->json($autos);
        
    }

    public function BuscarAuto($auto){
            
                 
       // $categorias = Sede::where('condicion','=','1')
       // ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();

       //('name', 'like', '%' . Input::get('name') . '%')->get();
       //echo $auto;

            $autos= Auto::where('placa','like', '%'.$auto.'%')
            ->where('id_vecino','=','0')
            ->get();
            return ['auto' => $autos];
            
    }

    public function ListarAutoAsign($id){
            
                 
        // $categorias = Sede::where('condicion','=','1')
        // ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
 
        //('name', 'like', '%' . Input::get('name') . '%')->get();
        //echo $auto;
 
             $autos= Auto::where('id_vecino','=',$id)->get();
             return ['auto' => $autos];
             
     }
     
     public function asignar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        echo $request->id;
        $categoria = Auto::findOrFail($request->id);
        $categoria->id_vecino= $request->id_vecino;
        $categoria->save();
    }
    
    public function liberar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        echo $request->id;
        $categoria = Auto::findOrFail($request->id);
        $categoria->id_vecino= "0";
        $categoria->save();
    }
}
