<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Exports\AutosExport;
use App\Exports\VecinoExport;
use App\Exports\ManzanaExport;
use App\Exports\LoteExport;
use App\Exports\DepartamentoExport;
use Maatwebsite\Excel\Facades\Excel;
 

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/timeout', 'Auth\LoginController@timeout')->name('timeout');
    Route::get('auto/android/{id}','AutoController@androidApp');
});

Route::group(['middleware'=>['auth']],function(){
    
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/dashboard', 'DashboardController');
    //Notificaciones 
    Route::post('/notification/get', 'NotificationController@get'); 
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Almacenero']], function () {
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPdf','CategoriaController@listarPdf')->name('categorias_pdf');

        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPdf','ProveedorController@listarPdf')->name('proveedores_pdf');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        Route::post('/dj/registrar', 'PacienteController@RegistrarDeclaracionJurada');
    });

    Route::group(['middleware' => ['Vendedor']], function () {
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf','ClienteController@listarPdf')->name('clientes_pdf');
 
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');
    });

    Route::group(['middleware' => ['Administrador']], function () {
        
        Route::get('/dashboard', 'DashboardController');
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPdf','CategoriaController@listarPdf')->name('categorias_pdf');

        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');
        Route::get('/articulo/selectProyecto', 'ArticuloController@selectProyecto');
        Route::get('/articulo/selectSede/{id}', 'ArticuloController@selectSede');
        Route::get('/articulo/selectUbicacion/{id}', 'ArticuloController@selectUbicacion');
        Route::get('/articulo/selectMarca', 'ArticuloController@selectMarca');
        Route::get('/articulo/selectModelo/{id}', 'ArticuloController@selectModelo');

        Route::get('/ubicacion', 'UbicacionController@index');
        Route::post('/ubicacion/registrar', 'UbicacionController@store');
        Route::get('/ubicacion/selectUbicacion', 'UbicacionController@selectUbicacion');
        /*
        Route::put('/ubicacion/actualizar', 'Ubicacion@update');
        Route::put('/ubicacion/desactivar', 'Ubicacion@desactivar');
        Route::put('/ubicacion/activar', 'Ubicacion@activar');
        Route::get('/ubicacion/buscarArticulo', 'Ubicacion@buscarArticulo');
        Route::get('/ubicacion/listarArticulo', 'Ubicacion@listarArticulo');
        Route::get('/ubicacion/buscarArticuloVenta', 'Ubicacion@buscarArticuloVenta');
        Route::get('/ubicacion/listarArticuloVenta', 'UbicacionlistarArticuloVenta');
        Route::get('/ubicacion/listarPdf','Ubicacion@listarPdf')->name('ubicacion_pdf');
        */

        Route::get('/marca', 'MarcaController@index');
        Route::post('/marca/registrar', 'MarcaController@store');
        Route::get('/ubicacion/selectUbicacion', 'UbicacionController@selectUbicacion');
        Route::put('/marca/actualizar', 'MarcaController@update');
        Route::put('/marca/desactivar', 'MarcaController@desactivar');
        Route::put('/marca/activar', 'MarcaController@activar');
        Route::get('/marca/selectMarca', 'MarcaController@selectMarca');



        Route::get('/modelo', 'ModeloController@index');
        Route::post('/modelo/registrar', 'ModeloController@store');
        Route::put('/modelo/actualizar', 'ModeloController@update');
        Route::put('/modelo/desactivar', 'ModeloController@desactivar');
        Route::put('/modelo/activar', 'ModeloController@activar');
        Route::post('/lote/registrar', 'LoteController@store');
        Route::get('/lote/ListarLoteAsign/{id}', 'LoteController@ListarLoteAsignada');
        Route::put('/lote/liberar', 'LoteController@liberar');
        Route::put('/departamento/liberar', 'DepartamentoController@liberar');

        Route::get('/sector', 'SectorController@index');
        Route::get('/auto', 'AutoController@index');
        Route::put('/auto/actualizar', 'AutoController@update');
        Route::put('/auto/asignar', 'AutoController@asignar');
        Route::put('/auto/liberar', 'AutoController@liberar');
        Route::post('/auto/registrar', 'AutoController@store');
        Route::get('/auto/BuscarAuto/{auto}', 'AutoController@BuscarAuto');
        Route::get('/auto/ListarAutoAsign/{id}', 'AutoController@ListarAutoAsign');
        Route::get('/examenes/excel', 'PacienteController@export');
        /*Route::get('examenes/excel', function () {
            return Excel::download(new AutosExport, 'examenes.xlsx');
        });*/
        Route::get('/persona/excel', function () {
            return Excel::download(new VecinoExport, 'personas.xlsx');
        });
        Route::get('/manzana/excel', function () {
            return Excel::download(new ManzanaExport, 'manzanas.xlsx');
        });
        Route::get('/lote/excel', function () {
            return Excel::download(new LoteExport, 'lotes.xlsx');
        });
        Route::get('/departamento/excel', function () {
            return Excel::download(new DepartamentoExport, 'departamentos.xlsx');
        });

        //Route::get('auto/android/{id}','AutoController@androidApp');
        
        Route::get('/manzana', 'ManzanaController@index');
        Route::get('/sector/selectSector','ManzanaController@selectSector');
        Route::get('/manzana/selectManzana','ManzanaController@selectManzana');
        Route::post('/manzana/registrar', 'ManzanaController@store');
        Route::get('/lote', 'LoteController@index');
        Route::put('/lote/actualizar', 'LoteController@update');
        Route::put('/lote/desactivar', 'LoteController@desactivar');
        Route::put('/lote/activar', 'LoteController@activar');
        Route::get('/lote/selectLote/{id}','LoteController@selectLote');
        Route::post('/lote/asignar', 'LoteController@asignar');
        Route::get('/departamento', 'DepartamentoController@index');
        Route::get('/manzana/selectManzana/{id}', 'ManzanaController@selectManzana');
        Route::put('/manzana/actualizar', 'ManzanaController@update');
        Route::put('/manzana/desactivar', 'ManzanaController@desactivar');
        Route::put('/manzana/activar', 'ManzanaController@activar');
        Route::post('/departamento/registrar', 'DepartamentoController@store');
        Route::put('/departamento/actualizar', 'DepartamentoController@update');
        Route::get('/departamento/ListarDepaAsign/{id}', 'DepartamentoController@ListarDepaAsignada');
        Route::get('/departamento/selectDepartamento/{id}', 'DepartamentoController@selectDepartamento');
        Route::post('/departamento/asignar', 'DepartamentoController@asignar');
        

        Route::get('/persona', 'PersonaController@index');
        Route::get('/personaPago', 'PacienteController@ListarPaciente');
        Route::get('/persona/BuscarDNI/{dni}/{criterio}', 'PersonaController@BuscarDNI');
        Route::post('/persona/registrar', 'PersonaController@store');
        Route::put('/persona/actualizar', 'PersonaController@update');



        Route::post('/sede/registrar', 'SedeController@store');
        Route::get('/sede/selectProyecto', 'SedeController@selectProyecto');
        Route::put('/sede/actualizar', 'SedeController@update');
        Route::put('/sede/desactivar', 'SedeController@desactivar');
        Route::put('/sede/activar', 'SedeController@activar');


        Route::post('/marca/registrar', 'MarcaController@store');
        Route::get('/ubicacion/selectUbicacion', 'UbicacionController@selectUbicacion');
        Route::get('/ubicacion/selectSede', 'UbicacionController@selectSede');
        Route::put('/ubicacion/actualizar', 'UbicacionController@update');
        Route::put('/ubicacion/desactivar', 'UbicacionController@desactivar');
        Route::put('/ubicacion/activar', 'UbicacionController@activar');

        Route::put('/marca/actualizar', 'MarcaController@update');
        Route::put('/marca/desactivar', 'MarcaController@desactivar');
        Route::put('/marca/activar', 'MarcaController@activar');
        /*
       
       
        Route::get('/ubicacion/buscarArticulo', 'Ubicacion@buscarArticulo');
        Route::get('/ubicacion/listarArticulo', 'Ubicacion@listarArticulo');
        Route::get('/ubicacion/buscarArticuloVenta', 'Ubicacion@buscarArticuloVenta');
        Route::get('/ubicacion/listarArticuloVenta', 'UbicacionlistarArticuloVenta');
        Route::get('/ubicacion/listarPdf','Ubicacion@listarPdf')->name('ubicacion_pdf');
        */

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPdf','ProveedorController@listarPdf')->name('proveedores_pdf');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf','ClienteController@listarPdf')->name('clientes_pdf');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');

        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        Route::get('/user/listarPdf','UserController@listarPdf')->name('usuarios_pdf');
        Route::get('/pagos/BuscarPersona/{id}', 'PagoController@BuscarPersona');
        Route::put('/pago/Completar', 'PagoController@Completar');
        Route::post('/pago/registrar', 'PagoController@store');
        Route::put('/recibo/eliminar', 'PagoController@eliminar');
        Route::put('/recibo/actualizar', 'PagoController@actualizar');
        Route::get('/paciente/buscar/{dni}/{criterio}', 'PacienteController@buscar');
        Route::get('/buscar/DatosAdicionales/{dni}', 'PacienteController@buscarDatosAdicionales');
        Route::get('/buscar/ExisteRegistro/{dni}', 'PacienteController@buscarExisteRegistro');
        Route::get('/listDep', 'PacienteController@ListarDepartamento');
        Route::get('/listPro', 'PacienteController@ListarProvincia');
        Route::get('/listDist', 'PacienteController@ListarDistrito');
        Route::get('/listEmp', 'PacienteController@ListarEmpresa');
        Route::post('/ficha/registrar', 'PacienteController@RegistrarPaciente');
        Route::post('/ficha/ponerestacion', 'PacienteController@PonerEstacion');
        Route::post('/datosclinicos/registrar', 'PacienteController@RegistrarDatosClinicos');
        Route::post('/pruebaserologica/registrar', 'PacienteController@RegistrarPruebaSerologica');
        Route::post('/pruebaserologica/iniciar', 'PacienteController@CrearPruebaSerologica');
        Route::post('/antecedentes/registrar', 'PacienteController@RegistrarAntecedentes');
        Route::post('/temperatura/registrar', 'PacienteController@RegistrarTemperatura');
        Route::post('/dj/registrar', 'PacienteController@RegistrarDeclaracionJurada');
        Route::post('/ci/registrar', 'PacienteController@RegistrarConsentimientoInformado');
        Route::post('/atres/registrar', 'PacienteController@RegistrarAnexoTres');
        Route::put('/fichapaciente/terminar', 'PacienteController@TerminarFicha');
        Route::get('/cargarEstados/{id}', 'PacienteController@CargarEstados');
        Route::get('/BuscarCodigoPs/{id}', 'PacienteController@BuscarCodigoPs');       
        Route::get('/listarPruebas', 'PacienteController@index');
        Route::get('/listarPruebasAdmision', 'PacienteController@indexAdmision');
        Route::get('/listarPruebasPendientes', 'PacienteController@indexPendientes');
        Route::get('/listarPruebasSintomaticos', 'PacienteController@indexSintomaticos');
        Route::get('/listarPruebasPasadas', 'PacienteController@indexPasadas');
        Route::get('/listarPruebasSerologicas', 'PacienteController@BuscarFichaPacientePruebaSerologica');
        Route::get('/distancias', 'PacienteController@CalcularDistancias');
        Route::get('/buscar/FichaPaciente/{dni}', 'PacienteController@BuscarFichaPaciente');
        Route::put('/iniciarprueba', 'PacienteController@IniciarPruebaSerologica');
        Route::put('/terminarprueba', 'PacienteController@TerminarPruebaSerologica');
        /*listDep
        listPro
        listDist
*/

        
    });

});

//Route::get('/home', 'HomeController@index')->name('home');
