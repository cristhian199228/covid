<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Proyecto;
use App\Sede;
use App\Ubicacion;
use App\Marca;
use App\Modelo;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('ubicacions', 'ubicacions.id', '=', 'articulos.idubicacion')
            ->join('sedes', 'sedes.id', '=', 'ubicacions.idsede')
            ->join('modelos', 'modelos.id', '=', 'articulos.idmodelo')
            ->join('marcas', 'marcas.id', '=', 'modelos.id_marca')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.descripcion','articulos.condicion','modelos.descripcion as mod_desc','categorias.nombre as cat_desc',
            'marcas.descripcion as marca_desc','articulos.nro_serie','articulos.nro_certificado','sedes.descripcion','sedes.descripcion as sede_desc',
            'ubicacions.nombre as ubi_desc','articulos.propietario')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function listarArticulo(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('ubicacion', 'ubicacion.id', '=', 'articulo.idubicacion')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.descripcion','articulos.condicion','ubicacion.nombre')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('ubicacion', 'ubicacion.id', '=', 'articulo.idubicacion')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.descripcion','articulos.condicion','ubicacion.nombre')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }
 
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock',
            'articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.nombre', 'asc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->download('articulos.pdf');
    }

    public function buscarArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function buscarArticuloVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['articulos' => $articulos];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) ;
        $articulo = new Articulo();
        $articulo->idcategoria = 1;
        $articulo->idubicacion = $request->idubicacion;
        $articulo->idmodelo = 1;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->nro_serie = $request->nro_serie;        
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function selectProyecto(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Proyecto::where('condicion','=','1')
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['proyecto' => $categorias];
    }
    public function selectSede($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Sede::where('condicion','=','1')
        ->where('idproyecto','=',$id)
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['sede' => $categorias];
    }
    
    public function selectUbicacion($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Ubicacion::where('condicion','=','1')
        ->where('idsede','=',$id)
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['ubicacion' => $categorias];
    }
    public function selectMarca(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Marca::where('condicion','=','1')        
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['marca' => $categorias];
    }
    public function selectModelo($id){
        //if (!$request->ajax()) return redirect('/');
        $categorias = Modelo::where('condicion','=','1')
        ->where('id_marca','=',$id)        
        ->select('id','descripcion')->orderBy('descripcion', 'asc')->get();
        return ['modelo' => $categorias];
    }
}
