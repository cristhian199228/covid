<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;
use App\Auto;
use App\Sede;
use App\Lote;
use App\Manzana;
use App\Paciente;
use App\PersonaZap;
use App\Comprobante;
use App\ExamenOcu;
use App\DepartamentoPeru;
use App\Provincia;
use App\Distrito;
use App\FichaPaciente;
use App\Empresa;
use App\DatosClinicos;
use App\PruebaSerologica;
use App\AntecedentesEp;
use App\Temperatura;
use App\DeclaracionJurada;
use App\ConsentimientoInformado;
use App\FichasPasadas;
use App\AnexoTres;
use App\Estacion;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AutosExport;


class PacienteController extends Controller
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
        $sede = $request->sede;

        $fechaActual = date('Y-m-d');

        if ($buscar == '') {
            if($sede == 1){
            $fichas = FichaPaciente::where('fecha',$fechaActual)
            ->where(function ($q) {
                $q->where('id_estacion', 1)
                    ->orWhere('id_estacion', 2)
                    ->orWhere('id_estacion', 3)
                    ->orWhere('id_estacion', 4)
                    ->orWhere('id_estacion', 5)
                    ->orWhere('id_estacion', 6)
                    ;
                                      
            })
            ->orderBy('created_at', 'DESC')->get();
        }

        if($sede == 2){
            $fichas = FichaPaciente::where('fecha',$fechaActual)
            ->where(function ($q) {
                $q->Where('id_estacion', 7)
                    ->orWhere('id_estacion', 8)
                    ->orWhere('id_estacion', 9)
                    ->orWhere('id_estacion', 10);
                                      
            })
            ->orderBy('created_at', 'DESC')->get();
        }
         
        if($sede == 3){
            $fichas = FichaPaciente::where('fecha',$fechaActual)
            ->where(function ($q) {
                $q->where('id_estacion', 11)
                    ->orWhere('id_estacion', 12)
                    ->orWhere('id_estacion', 13)
                    ->orWhere('id_estacion', 14)
                    ->orWhere('id_estacion', 15)
                    ->orWhere('id_estacion', 16)
                    ->orWhere('id_estacion', 17)
                    ->orWhere('id_estacion', 18)
                    ->orWhere('id_estacion', 19)
                    ->orWhere('id_estacion', 20);
                                      
            })
            ->orderBy('created_at', 'DESC')->get();
        }
        
        
        
        $contador = $fichas->count() +1 ;
            //
    //echo ($contador);
            foreach ($fichas as $ficha) {
                $id =  $ficha->idficha_paciente;
                $contador = $contador - 1 ;
                $ficha->contador = $contador;
                if ($ficha->puesto == "") {
                    $ficha->puesto = $ficha->puesto_mw;
                }


                $id_estacion = $ficha->id_estacion;
                $estacion = Estacion::where('idestaciones', $id_estacion)->first();
                if (is_null($estacion)) {
                    $estacion_abrev = '-';
                }
                else{
                    if ($estacion->sede == 'CHILINA')
                    $estacion_abrev = 'CHI' . $estacion->nombre_estacion;
                    if ($estacion->sede == 'JUAN PABLO')
                    $estacion_abrev = 'JUANP.' . $estacion->nombre_estacion;
                if ($estacion->sede == 'COMPLEJO')
                    $estacion_abrev = 'COMP' . $estacion->nombre_estacion;
                }
                

                //dd($estacion);

                $ficha->estacion = $estacion_abrev;




                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('tos', 1)
                            ->orWhere('dolor_garganta', 1)
                            ->orWhere('dificultad_respiratoria', 1)
                            ->orWhere('fiebre', 1)
                            ->orWhere('malestar_general', 1)
                            ->orWhere('diarrea', 1)
                            ->orWhere('anosmia_ausegia', 1)
                            ->orwhereNotNull('otros')
                            ->orwhereNotNull('toma_medicamento')
                            ->orwhereNotNull('debilite_sistema')
                            ->orWhere('nauseas_vomitos', 1)
                            ->orWhere('congestion_nasal', 1)
                            ->orWhere('cefalea', 1)
                            ->orWhere('irritabilidad_confusion', 1)
                            ->orWhere('falta_aliento', 1);
                    })
                    ->count();

                if ($datosclinicos == 0) {
                    $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($datosclinicos)) {
                        $datosclinicos = "";
                    } else {
                        $datosclinicos = "NO";
                    }
                } else {
                    $datosclinicos = "SI";
                }


                $ficha->anamnesis = $datosclinicos;


                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('dias_viaje', 1)
                            ->orWhere('contacto_cercano', 1)
                            ->orWhere('conv_covid', 1)
                            ->orwhereNotNull('paises_visitados');
                    })
                    ->count();


                if ($antecedentesep == 0) {
                    $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($antecedentesep)) {
                        $antecedentesep = "";
                    } else {
                        $antecedentesep = "NO";
                    }
                } else {
                    $antecedentesep = "SI";
                }


                $ficha->antecedentesep = $antecedentesep;


                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('p1_react1gm', 1)
                            ->orWhere('p1_reactigg', 1)
                            ->orWhere('p1_reactigm_igg', 1);
                    })
                    ->count();

                if ($pruebaseriologica == 0) {
                    $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($pruebaseriologica)) {
                        $pruebaseriologica = "";
                    } else {
                        $pruebaseriologica = "NO";
                    }
                } else {
                    $pruebaseriologica = "SI";
                }




                $ficha->pruebaSerologica = $pruebaseriologica;

                $temperatura = Temperatura::where('idfichapacientes', $id)
                    ->first();
                //dd($temperatura);
                if (is_null($temperatura)) {
                } else {
                    $ficha->temperatura = $temperatura->valortemp;
                }
            }
        } else {

            if ($criterio == 'nombre_completo') {

                if($sede == 1){

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                ->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 1)
                        ->orWhere('id_estacion', 2)
                        ->orWhere('id_estacion', 3)
                        ->orWhere('id_estacion', 4)
                        ->orWhere('id_estacion', 5)
                        ->orWhere('id_estacion', 6)
                        ->orWhere('id_estacion', 7)
                        ->orWhere('id_estacion', 8)
                        ->orWhere('id_estacion', 9)
                        ->orWhere('id_estacion', 10);
                                          
                })
                ->orderBy('created_at', 'ASC')
                    ->get();
            }

            if($sede == 2){

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                ->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 11)
                        ->orWhere('id_estacion', 12)
                        ->orWhere('id_estacion', 13)
                        ->orWhere('id_estacion', 14)
                        ->orWhere('id_estacion', 15)
                        ->orWhere('id_estacion', 16)
                        ->orWhere('id_estacion', 17)
                        ->orWhere('id_estacion', 18)
                        ->orWhere('id_estacion', 19)
                        ->orWhere('id_estacion', 20);
                                          
                })
                ->orderBy('created_at', 'ASC')
                    ->get();
            }

            }
            if ($criterio == 'dni') {
            if($sede == 1){

                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 1)
                        ->orWhere('id_estacion', 2)
                        ->orWhere('id_estacion', 3)
                        ->orWhere('id_estacion', 4)
                        ->orWhere('id_estacion', 5)
                        ->orWhere('id_estacion', 6)
                        ->orWhere('id_estacion', 7)
                        ->orWhere('id_estacion', 8)
                        ->orWhere('id_estacion', 9)
                        ->orWhere('id_estacion', 10);
                                          
                })                
                ->orderBy('created_at', 'ASC')->get();
            
            }
        
            if($sede == 2){

                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 11)
                        ->orWhere('id_estacion', 12)
                        ->orWhere('id_estacion', 13)
                        ->orWhere('id_estacion', 14)
                        ->orWhere('id_estacion', 15)
                        ->orWhere('id_estacion', 16)
                        ->orWhere('id_estacion', 17)
                        ->orWhere('id_estacion', 18)
                        ->orWhere('id_estacion', 19)
                        ->orWhere('id_estacion', 20);
                                          
                })                
                ->orderBy('created_at', 'ASC')->get();
            
            }
        
        }
            if ($criterio == 'registro') {
                if($sede == 1){

                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 1)
                        ->orWhere('id_estacion', 2)
                        ->orWhere('id_estacion', 3)
                        ->orWhere('id_estacion', 4)
                        ->orWhere('id_estacion', 5)
                        ->orWhere('id_estacion', 6)
                        ->orWhere('id_estacion', 7)
                        ->orWhere('id_estacion', 8)
                        ->orWhere('id_estacion', 9)
                        ->orWhere('id_estacion', 10);
                                          
                })
                ->orderBy('created_at', 'ASC')->get();
            }
            if($sede == 2){

                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)
                ->where(function ($q) {
                    $q->where('id_estacion', 11)
                        ->orWhere('id_estacion', 12)
                        ->orWhere('id_estacion', 13)
                        ->orWhere('id_estacion', 14)
                        ->orWhere('id_estacion', 15)
                        ->orWhere('id_estacion', 16)
                        ->orWhere('id_estacion', 17)
                        ->orWhere('id_estacion', 18)
                        ->orWhere('id_estacion', 19)
                        ->orWhere('id_estacion', 20);
                                          
                })
                ->orderBy('created_at', 'ASC')->get();
            }
        }
        }



        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;

            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }

            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;


            $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentesep = $antecedentesep;


            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->whereNotNull('hora_fin')
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "";
                } else {
                    $pruebaseriologica = "NO";
                }
            } else {
                $pruebaseriologica = "SI";
            }




            $ficha->pruebaSerologica = $pruebaseriologica;

            $temperatura = Temperatura::where('idfichapacientes', $id)
                ->first();
            //dd($temperatura);
            if (is_null($temperatura)) {
            } else {
                $ficha->temperatura = $temperatura->valortemp;
            }
        }







        return [
           
            'categorias' => $fichas
        ];
    }



    public function export(Request $request)
    {

        $fechaActual = date('Y-m-d');
        $fichas = FichaPaciente::select('idficha_paciente','fecha','nombre_completo','idtipodocumento','dni','numero_registro','empresa','puesto','anamnesis','antecedentes_ep','temperatura','prueba_serologica')
       
        ->orderBy('fecha', 'ASC')->get();
        
        
      
        //
//echo ($contador);
        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;
            
            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }


            if($ficha->anamnesis == ""){


            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "NO";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;

        }
        if(is_null($ficha->antecedentes_ep)){
  

        $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "NO";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentes_ep = $antecedentesep;

        }

       
            if(is_null($ficha->temperatura)){
            $temperatura = Temperatura::where('idfichapacientes', $id)
            ->first();
        //dd($temperatura);
        if (is_null($temperatura)) {
            $ficha->temperatura = '36.6';
        } else {
            $ficha->temperatura = $temperatura->valortemp;
        }

    }

    
    if($ficha->prueba_serologica == " "){
        if(is_null($ficha->prueba_serologica)){
            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "NEGATIVO";
                } else {
                    $pruebaseriologica = "NEGATIVO";
                }
            } else {
                $pruebaseriologica = "POSITIVO";
            }




            $ficha->prueba_serologica = $pruebaseriologica;

            
        }
        }




        //return Excel::download(new MttRegistrationsExport($request->id), 'MttRegistrations.xlsx');
        return Excel::download(new AutosExport($fichas), 'examenes.xlsx');
    }


    }


    public function indexAdmision(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $estacion = $request->estacion;

        $fechaActual = date('Y-m-d');

        if ($buscar == '') {
            $fichas = FichaPaciente::where('fecha',$fechaActual)
            ->where('id_estacion',$estacion)
            ->orderBy('created_at', 'DESC')
            ->get();

            $contador = $fichas->count() +1 ;
            foreach ($fichas as $ficha) {
                $contador = $contador - 1 ;
                $id =  $ficha->idficha_paciente;

                $ficha->contador = $contador;

                if ($ficha->puesto == "") {
                    $ficha->puesto = $ficha->puesto_mw;
                }


                $id_estacion = $ficha->id_estacion;
                $estacion = Estacion::where('idestaciones', $id_estacion)->first();
                if (is_null($estacion)) {
                    $estacion_abrev = '-';
                }
                else{
                    if ($estacion->sede == 'CHILINA')
                    $estacion_abrev = 'CHI' . $estacion->nombre_estacion;
                if ($estacion->sede == 'COMPLEJO')
                    $estacion_abrev = 'COMP' . $estacion->nombre_estacion;
                }
                

                //dd($estacion);

                $ficha->estacion = $estacion_abrev;




                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('tos', 1)
                            ->orWhere('dolor_garganta', 1)
                            ->orWhere('dificultad_respiratoria', 1)
                            ->orWhere('fiebre', 1)
                            ->orWhere('malestar_general', 1)
                            ->orWhere('diarrea', 1)
                            ->orWhere('anosmia_ausegia', 1)
                            ->orwhereNotNull('otros')
                            ->orwhereNotNull('toma_medicamento')
                            ->orwhereNotNull('debilite_sistema')
                            ->orWhere('nauseas_vomitos', 1)
                            ->orWhere('congestion_nasal', 1)
                            ->orWhere('cefalea', 1)
                            ->orWhere('irritabilidad_confusion', 1)
                            ->orWhere('falta_aliento', 1);
                    })
                    ->count();

                if ($datosclinicos == 0) {
                    $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($datosclinicos)) {
                        $datosclinicos = "";
                    } else {
                        $datosclinicos = "NO";
                    }
                } else {
                    $datosclinicos = "SI";
                }


                $ficha->anamnesis = $datosclinicos;


                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('dias_viaje', 1)
                            ->orWhere('contacto_cercano', 1)
                            ->orWhere('conv_covid', 1)
                            ->orwhereNotNull('paises_visitados');
                    })
                    ->count();


                if ($antecedentesep == 0) {
                    $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($antecedentesep)) {
                        $antecedentesep = "";
                    } else {
                        $antecedentesep = "NO";
                    }
                } else {
                    $antecedentesep = "SI";
                }


                $ficha->antecedentesep = $antecedentesep;


                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('p1_react1gm', 1)
                            ->orWhere('p1_reactigg', 1)
                            ->orWhere('p1_reactigm_igg', 1);
                    })
                    ->count();

                if ($pruebaseriologica == 0) {
                    $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($pruebaseriologica)) {
                        $pruebaseriologica = "";
                    } else {
                        $pruebaseriologica = "NO";
                    }
                } else {
                    $pruebaseriologica = "SI";
                }




                $ficha->pruebaSerologica = $pruebaseriologica;

                $temperatura = Temperatura::where('idfichapacientes', $id)
                    ->first();
                //dd($temperatura);
                if (is_null($temperatura)) {
                } else {
                    $ficha->temperatura = $temperatura->valortemp;
                }
            }
        } else {

            if ($criterio == 'nombre_completo') {

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                ->where('fecha',$fechaActual)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            if ($criterio == 'dni') {


                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)->orderBy('createed_at', 'desc')->get();
            }
            if ($criterio == 'registro') {


                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)->orderBy('created_at', 'desc')->get();
            }
        }



        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;

            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }

            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;


            $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentesep = $antecedentesep;


            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->whereNotNull('hora_fin')
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "";
                } else {
                    $pruebaseriologica = "NO";
                }
            } else {
                $pruebaseriologica = "SI";
            }




            $ficha->pruebaSerologica = $pruebaseriologica;

            $temperatura = Temperatura::where('idfichapacientes', $id)
                ->first();
            //dd($temperatura);
            if (is_null($temperatura)) {
            } else {
                $ficha->temperatura = $temperatura->valortemp;
            }
        }







        return [/*
            'pagination' => [
                'total'        => $fichas->total(),
                'current_page' => $fichas->currentPage(),
                'per_page'     => $fichas->perPage(),
                'last_page'    => $fichas->lastPage(),
                'from'         => $fichas->firstItem(),
                'to'           => $fichas->lastItem(),
            ],*/
            'categorias' => $fichas
        ];
    }

    public function indexPendientes(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $fichas = FichaPaciente::where('estado', 0)->paginate(10);


            foreach ($fichas as $ficha) {
                $id =  $ficha->idficha_paciente;

                if ($ficha->puesto == "") {
                    $ficha->puesto = $ficha->puesto_mw;
                }

                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('tos', 1)
                            ->orWhere('dolor_garganta', 1)
                            ->orWhere('dificultad_respiratoria', 1)
                            ->orWhere('fiebre', 1)
                            ->orWhere('malestar_general', 1)
                            ->orWhere('diarrea', 1)
                            ->orWhere('anosmia_ausegia', 1)
                            ->orwhereNotNull('otros')
                            ->orwhereNotNull('toma_medicamento')
                            ->orwhereNotNull('debilite_sistema')
                            ->orWhere('nauseas_vomitos', 1)
                            ->orWhere('congestion_nasal', 1)
                            ->orWhere('cefalea', 1)
                            ->orWhere('irritabilidad_confusion', 1)
                            ->orWhere('falta_aliento', 1);
                    })
                    ->count();

                if ($datosclinicos == 0) {
                    $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($datosclinicos)) {
                        $datosclinicos = "";
                    } else {
                        $datosclinicos = "NO";
                    }
                } else {
                    $datosclinicos = "SI";
                }


                $ficha->anamnesis = $datosclinicos;


                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('dias_viaje', 1)
                            ->orWhere('contacto_cercano', 1)
                            ->orWhere('conv_covid', 1)
                            ->orwhereNotNull('paises_visitados');
                    })
                    ->count();


                if ($antecedentesep == 0) {
                    $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($antecedentesep)) {
                        $antecedentesep = "";
                    } else {
                        $antecedentesep = "NO";
                    }
                } else {
                    $antecedentesep = "SI";
                }


                $ficha->antecedentesep = $antecedentesep;


                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('p1_react1gm', 1)
                            ->orWhere('p1_reactigg', 1)
                            ->orWhere('p1_reactigm_igg', 1);
                    })
                    ->count();

                if ($pruebaseriologica == 0) {
                    $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($pruebaseriologica)) {
                        $pruebaseriologica = "";
                    } else {
                        $pruebaseriologica = "NO";
                    }
                } else {
                    $pruebaseriologica = "SI";
                }




                $ficha->pruebaSerologica = $pruebaseriologica;

                $temperatura = Temperatura::where('idfichapacientes', $id)
                    ->first();
                //dd($temperatura);
                if (is_null($temperatura)) {
                } else {
                    $ficha->temperatura = $temperatura->valortemp;
                }
            }
        } else {

            if ($criterio == 'nombre_completo') {

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                    ->orderBy('idficha_paciente', 'desc')
                    ->paginate(10);
            }
            if ($criterio == 'dni') {


                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->orderBy('idficha_paciente', 'desc')->paginate(10);
            }
            if ($criterio == 'registro') {


                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->orderBy('idficha_paciente', 'desc')->paginate(10);
            }
        }



        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;

            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }

            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;


            $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentesep = $antecedentesep;


            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "";
                } else {
                    $pruebaseriologica = "NO";
                }
            } else {
                $pruebaseriologica = "SI";
            }




            $ficha->pruebaSerologica = $pruebaseriologica;

            $temperatura = Temperatura::where('idfichapacientes', $id)
                ->first();
            //dd($temperatura);
            if (is_null($temperatura)) {
            } else {
                $ficha->temperatura = $temperatura->valortemp;
            }
        }







        return [
            'pagination' => [
                'total'        => $fichas->total(),
                'current_page' => $fichas->currentPage(),
                'per_page'     => $fichas->perPage(),
                'last_page'    => $fichas->lastPage(),
                'from'         => $fichas->firstItem(),
                'to'           => $fichas->lastItem(),
            ],
            'categorias' => $fichas
        ];
    }

    public function indexSintomaticos(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $fichas = FichaPaciente::paginate(10);


            foreach ($fichas as $ficha) {
                $id =  $ficha->idficha_paciente;

                if ($ficha->puesto == "") {
                    $ficha->puesto = $ficha->puesto_mw;
                }

                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('tos', 1)
                            ->orWhere('dolor_garganta', 1)
                            ->orWhere('dificultad_respiratoria', 1)
                            ->orWhere('fiebre', 1)
                            ->orWhere('malestar_general', 1)
                            ->orWhere('diarrea', 1)
                            ->orWhere('anosmia_ausegia', 1)
                            ->orwhereNotNull('otros')
                            ->orwhereNotNull('toma_medicamento')
                            ->orwhereNotNull('debilite_sistema')
                            ->orWhere('nauseas_vomitos', 1)
                            ->orWhere('congestion_nasal', 1)
                            ->orWhere('cefalea', 1)
                            ->orWhere('irritabilidad_confusion', 1)
                            ->orWhere('falta_aliento', 1);
                    })
                    ->count();

                if ($datosclinicos == 0) {
                    $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($datosclinicos)) {
                        $datosclinicos = "";
                    } else {
                        $datosclinicos = "NO";
                    }
                } else {
                    $datosclinicos = "SI";
                }


                $ficha->anamnesis = $datosclinicos;


                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('dias_viaje', 1)
                            ->orWhere('contacto_cercano', 1)
                            ->orWhere('conv_covid', 1)
                            ->orwhereNotNull('paises_visitados');
                    })
                    ->count();


                if ($antecedentesep == 0) {
                    $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($antecedentesep)) {
                        $antecedentesep = "";
                    } else {
                        $antecedentesep = "NO";
                    }
                } else {
                    $antecedentesep = "SI";
                }


                $ficha->antecedentesep = $antecedentesep;


                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('p1_react1gm', 1)
                            ->orWhere('p1_reactigg', 1)
                            ->orWhere('p1_reactigm_igg', 1);
                    })
                    ->count();

                if ($pruebaseriologica == 0) {
                    $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($pruebaseriologica)) {
                        $pruebaseriologica = "";
                    } else {
                        $pruebaseriologica = "NO";
                    }
                } else {
                    $pruebaseriologica = "SI";
                }




                $ficha->pruebaSerologica = $pruebaseriologica;

                $temperatura = Temperatura::where('idfichapacientes', $id)
                    ->first();
                //dd($temperatura);
                if (is_null($temperatura)) {
                } else {
                    $ficha->temperatura = $temperatura->valortemp;
                }
            }
        } else {

            if ($criterio == 'nombre_completo') {

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                    ->orderBy('idficha_paciente', 'desc')
                    ->paginate(10);
            }
            if ($criterio == 'dni') {


                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->orderBy('idficha_paciente', 'desc')->paginate(10);
            }
            if ($criterio == 'registro') {


                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->orderBy('idficha_paciente', 'desc')->paginate(10);
            }
        }



        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;

            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }

            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;


            $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentesep = $antecedentesep;


            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "";
                } else {
                    $pruebaseriologica = "NO";
                }
            } else {
                $pruebaseriologica = "SI";
            }




            $ficha->pruebaSerologica = $pruebaseriologica;

            $temperatura = Temperatura::where('idfichapacientes', $id)
                ->first();
            //dd($temperatura);
            if (is_null($temperatura)) {
            } else {
                $ficha->temperatura = $temperatura->valortemp;
            }
        }







        return [
            'pagination' => [
                'total'        => $fichas->total(),
                'current_page' => $fichas->currentPage(),
                'per_page'     => $fichas->perPage(),
                'last_page'    => $fichas->lastPage(),
                'from'         => $fichas->firstItem(),
                'to'           => $fichas->lastItem(),
            ],
            'categorias' => $fichas
        ];
    }
    public function indexPasadas(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $fechaActual = date('Y-m-d');

        if ($buscar == '') {
            $fichas = FichaPaciente::where('fecha',$fechaActual)->orderBy('created_at', 'ASC')->get();
            
            $contador = $fichas->count() +1 ;
            //
    //echo ($contador);
            foreach ($fichas as $ficha) {
                $id =  $ficha->idficha_paciente;
                $contador = $contador - 1 ;
                $ficha->contador = $contador;
                if ($ficha->puesto == "") {
                    $ficha->puesto = $ficha->puesto_mw;
                }


                $id_estacion = $ficha->id_estacion;
                $estacion = Estacion::where('idestaciones', $id_estacion)->first();
                if (is_null($estacion)) {
                    $estacion_abrev = '-';
                }
                else{
                    if ($estacion->sede == 'CHILINA')
                    $estacion_abrev = 'CHI' . $estacion->nombre_estacion;
                if ($estacion->sede == 'COMPLEJO')
                    $estacion_abrev = 'COMP' . $estacion->nombre_estacion;
                }
                

                //dd($estacion);

                $ficha->estacion = $estacion_abrev;




                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('tos', 1)
                            ->orWhere('dolor_garganta', 1)
                            ->orWhere('dificultad_respiratoria', 1)
                            ->orWhere('fiebre', 1)
                            ->orWhere('malestar_general', 1)
                            ->orWhere('diarrea', 1)
                            ->orWhere('anosmia_ausegia', 1)
                            ->orwhereNotNull('otros')
                            ->orwhereNotNull('toma_medicamento')
                            ->orwhereNotNull('debilite_sistema')
                            ->orWhere('nauseas_vomitos', 1)
                            ->orWhere('congestion_nasal', 1)
                            ->orWhere('cefalea', 1)
                            ->orWhere('irritabilidad_confusion', 1)
                            ->orWhere('falta_aliento', 1);
                    })
                    ->count();

                if ($datosclinicos == 0) {
                    $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($datosclinicos)) {
                        $datosclinicos = "";
                    } else {
                        $datosclinicos = "NO";
                    }
                } else {
                    $datosclinicos = "SI";
                }


                $ficha->anamnesis = $datosclinicos;


                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('dias_viaje', 1)
                            ->orWhere('contacto_cercano', 1)
                            ->orWhere('conv_covid', 1)
                            ->orwhereNotNull('paises_visitados');
                    })
                    ->count();


                if ($antecedentesep == 0) {
                    $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($antecedentesep)) {
                        $antecedentesep = "";
                    } else {
                        $antecedentesep = "NO";
                    }
                } else {
                    $antecedentesep = "SI";
                }


                $ficha->antecedentesep = $antecedentesep;


                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                    ->where(function ($q) {
                        $q->where('p1_react1gm', 1)
                            ->orWhere('p1_reactigg', 1)
                            ->orWhere('p1_reactigm_igg', 1);
                    })
                    ->count();

                if ($pruebaseriologica == 0) {
                    $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                        ->first();

                    if (is_null($pruebaseriologica)) {
                        $pruebaseriologica = "";
                    } else {
                        $pruebaseriologica = "NO";
                    }
                } else {
                    $pruebaseriologica = "SI";
                }




                $ficha->pruebaSerologica = $pruebaseriologica;

                $temperatura = Temperatura::where('idfichapacientes', $id)
                    ->first();
                //dd($temperatura);
                if (is_null($temperatura)) {
                } else {
                    $ficha->temperatura = $temperatura->valortemp;
                }
            }
        } else {

            if ($criterio == 'nombre_completo') {

                $fichas = FichaPaciente::where(DB::raw($criterio), 'like', '%' . $buscar . '%')
                ->where('fecha',$fechaActual)
                ->orderBy('created_at', 'ASC')
                    ->get();
            }
            if ($criterio == 'dni') {


                $fichas = FichaPaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)->orderBy('created_at', 'ASC')->get();
            }
            if ($criterio == 'registro') {


                $fichas = Fichapaciente::where($criterio, 'like', '%' . $buscar . '%')->where('fecha',$fechaActual)->orderBy('created_at', 'ASC')->get();
            }
        }



        foreach ($fichas as $ficha) {
            $id =  $ficha->idficha_paciente;

            if ($ficha->puesto == "") {
                $ficha->puesto = $ficha->puesto_mw;
            }

            $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('tos', 1)
                        ->orWhere('dolor_garganta', 1)
                        ->orWhere('dificultad_respiratoria', 1)
                        ->orWhere('fiebre', 1)
                        ->orWhere('malestar_general', 1)
                        ->orWhere('diarrea', 1)
                        ->orWhere('anosmia_ausegia', 1)
                        ->orwhereNotNull('otros')
                        ->orwhereNotNull('toma_medicamento')
                        ->orwhereNotNull('debilite_sistema')
                        ->orWhere('nauseas_vomitos', 1)
                        ->orWhere('congestion_nasal', 1)
                        ->orWhere('cefalea', 1)
                        ->orWhere('irritabilidad_confusion', 1)
                        ->orWhere('falta_aliento', 1);
                })
                ->count();

            if ($datosclinicos == 0) {
                $datosclinicos = DatosClinicos::where('idfichapacientes', $id)
                    ->first();

                if (is_null($datosclinicos)) {
                    $datosclinicos = "";
                } else {
                    $datosclinicos = "NO";
                }
            } else {
                $datosclinicos = "SI";
            }


            $ficha->anamnesis = $datosclinicos;


            $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('dias_viaje', 1)
                        ->orWhere('contacto_cercano', 1)
                        ->orWhere('conv_covid', 1)
                        ->orwhereNotNull('paises_visitados');
                })
                ->count();


            if ($antecedentesep == 0) {
                $antecedentesep = AntecedentesEp::where('idfichapacientes', $id)
                    ->first();

                if (is_null($antecedentesep)) {
                    $antecedentesep = "";
                } else {
                    $antecedentesep = "NO";
                }
            } else {
                $antecedentesep = "SI";
            }


            $ficha->antecedentesep = $antecedentesep;


            $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->where(function ($q) {
                    $q->where('p1_react1gm', 1)
                        ->orWhere('p1_reactigg', 1)
                        ->orWhere('p1_reactigm_igg', 1);
                })
                ->count();

            if ($pruebaseriologica == 0) {
                $pruebaseriologica = PruebaSerologica::where('idfichapacientes', $id)
                ->whereNotNull('hora_fin')
                    ->first();

                if (is_null($pruebaseriologica)) {
                    $pruebaseriologica = "";
                } else {
                    $pruebaseriologica = "NO";
                }
            } else {
                $pruebaseriologica = "SI";
            }




            $ficha->pruebaSerologica = $pruebaseriologica;

            $temperatura = Temperatura::where('idfichapacientes', $id)
                ->first();
            //dd($temperatura);
            if (is_null($temperatura)) {
            } else {
                $ficha->temperatura = $temperatura->valortemp;
            }
        }







        return [
           
            'categorias' => $fichas
        ];
    }

    public function buscar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')

        // echo $request->criterio;
        if ($request->criterio == "dni") {

            $mediweb = Paciente::select('idpaciente', 'nombres', 'apellido_paterno', 'apellido_materno', 'dni2 as dni')
                ->where('dni2', 'like', '%' . $request->dni . '%')->get();



            if ($mediweb->count() > 0) {
                foreach ($mediweb as $exam) {
                    $id =  $exam->idpaciente;

                    $comprobante = Comprobante::select('idcomprobante')
                        ->where('estado', "=", '1')
                        ->where('idpaciente', '=', $id)
                        ->orderby('fecha', 'DESC')->take(1)->get();


                    $exam->comprobante = $comprobante;
                }
                foreach ($mediweb as $exam) {
                    foreach ($exam->comprobante as $exam2) {
                        $id =  $exam2->idcomprobante;

                        $comprobante = Comprobante::select('empresa.descripcion as empresa', 'comprobante.area as area_mw', 'comprobante.puesto as puesto_mw', 'empresa.idempresa as idempresa')
                            ->join('empresa', 'empresa.idempresa', '=', 'comprobante.idsubcontrata')
                            ->where('comprobante.idcomprobante', '=', $id)->get();

                        //$related = new Collection();
                        //$merged =   $collection->merge($item);

                        if ($comprobante->count() > 0) {
                            foreach ($comprobante as $valor) {



                                $exam->empresa = $valor['empresa'];
                                $exam->idempresa = $valor['idempresa'];
                                $exam->area_mw = $valor['area_mw'];
                                $exam->puesto_mw = $valor['puesto_mw'];
                            }
                        } else
                            $exam->empresa = 'SOCIEDAD MINERA CERRO VERDE';
                    }
                }
            } else {
                $mediweb = PersonaZap::select('nombres_apellidos as nombres', 'registro as registro', 'num_documento as dni')
                    ->where('num_documento', 'like', '%' . $request->dni . '%')->get();
                foreach ($mediweb as $empresa) {
                    $empresa->empresa = 'SOCIEDAD MINERA CERRO VERDE';
                }
            }
        }


        if ($request->criterio == "nombres") {


            $criterio = 'concat(nombres," ",apellido_paterno," ",apellido_materno)';

            $mediweb = Paciente::select('idpaciente', 'nombres', 'apellido_paterno', 'apellido_materno', 'dni2 as dni')
                ->where(DB::raw($criterio), 'like', '%' . $request->dni . '%')
                ->get();

            /* $zap = PersonaZap::select('registro','puesto','gerencia','area')
    ->where('dni','like', '%'.$request->dni.'%')->get();*/


            foreach ($mediweb as $exam) {
                $id =  $exam->idpaciente;

                $comprobante = Comprobante::select('idcomprobante')
                    ->where('estado', "=", '1')
                    ->where('idpaciente', '=', $id)
                    ->orderby('fecha', 'DESC')->take(1)->get();

                //$related = new Collection();
                //$merged =   $collection->merge($item);

                $exam->comprobante = $comprobante;
            }

            foreach ($mediweb as $exam) {
                foreach ($exam->comprobante as $exam2) {
                    $id =  $exam2->idcomprobante;

                    $comprobante = Comprobante::select('empresa.descripcion as empresa', 'empresa.idempresa as idempresa', 'comprobante.area as area_mw', 'comprobante.puesto as puesto_mw')
                        ->join('empresa', 'empresa.idempresa', '=', 'comprobante.idsubcontrata')
                        ->where('comprobante.idcomprobante', '=', $id)->get();

                    //$related = new Collection();
                    //$merged =   $collection->merge($item);

                    if ($comprobante->count() > 0) {
                        foreach ($comprobante as $valor) {



                            $exam->empresa = $valor['empresa'];
                            $exam->idempresa = $valor['idempresa'];
                            $exam->area_mw = $valor['area_mw'];
                            $exam->puesto_mw = $valor['puesto_mw'];
                        }
                    } else
                        $exam->empresa = 'SOCIEDAD MINERA CERRO VERDE';
                }
            }
        }

        if ($request->criterio == "registro") {


            /*$mediweb= Paciente::select('idpaciente','nombres','apellido_paterno','apellido_materno','dni2 as dni')
       ->where('dni2','like', '%'.$request->dni.'%')->get();*/

            $mediweb = PersonaZap::select('nombres_apellidos as nombres', 'registro as registro', 'num_documento as dni')
                ->where('registro', 'like', '%' . $request->dni . '%')->get();


            foreach ($mediweb as $exam) {
                $id =  $exam->idpaciente;

                $comprobante = Comprobante::select('idcomprobante')
                    ->where('estado', "=", '1')
                    ->where('idpaciente', '=', $id)
                    ->orderby('fecha', 'DESC')->take(1)->get();

                //$related = new Collection();
                //$merged =   $collection->merge($item);

                $exam->comprobante = $comprobante;
                $exam->empresa = 'SOCIEDAD MINERA CERRO VERDE';
            }
        }




        return ['paciente' => $mediweb];
    }

    public function buscarDatosAdicionales(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')

        /* $zap = PersonaZap::select('registro','puesto','gerencia','area')
       ->where('dni','like', '%'.$request->dni.'%')->get();*/



        $mediweb = Paciente::select(
            'paciente.nombres',
            'paciente.apellido_materno',
            'paciente.apellido_paterno',
            'paciente.direccion',
            'paciente.telefono',
            'graldistritos.nombre as distrito',
            'gralprovincias.nombre as provincia',
            'graldepartamentos.nombre as departamento',
            'graldistritos.iddistrito as distrito_id',
            'gralprovincias.idprovincia as provincia_id',
            'graldepartamentos.iddepartamento as departamento_id',
            'paciente.dni2 as dni',
            'paciente.idtipodocumento as tipodocumento',
            'paciente.correo as email'
        )
            ->leftjoin('graldistritos', 'graldistritos.iddistrito', '=', 'paciente.iddistrito')
            ->leftjoin('gralprovincias', 'gralprovincias.idprovincia', '=', 'paciente.idprovincia')
            ->leftjoin('graldepartamentos', 'graldepartamentos.iddepartamento', '=', 'paciente.iddepartamento')
            ->where('paciente.dni2', 'like', '%' . $request->dni . '%')->get();

        foreach ($mediweb as $zap) {

            $nombre_completo_i = trim($zap->nombres . ' ' . $zap->apellido_paterno . ' ' . $zap->apellido_materno);
            //echo ('nombre_completo'.$nombre_completo_i);
            $codigo =  $this->iniciales($nombre_completo_i);
            //$zap->codigops = $codigo;
            $dni_dos = substr($zap->dni, strlen($zap->dni) - 2, strlen($zap->dni));
            $zap->codigops = $codigo . $dni_dos;

            $Paciente = PersonaZap::select('puesto', 'area', 'gerencia', 'registro')
                ->where('num_documento', '=', $request->dni)->get();
            foreach ($Paciente as $datos_a) {

                $zap->puesto = $datos_a['puesto'];
                $zap->area = $datos_a['area'];
                $zap->gerencia = $datos_a['gerencia'];
                $zap->registro = $datos_a['registro'];
            }
        }

        //dd($categorias[0]);
        //$encodedData = json_encode($categorias, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_IGNORE);
        //dd($categorias);


        //dd($mediweb);

        return ['paciente' => $mediweb];
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

    }





    public function buscarExisteRegistro(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')

        /* $zap = PersonaZap::select('registro','puesto','gerencia','area')
       ->where('dni','like', '%'.$request->dni.'%')->get();*/
        $fechaActual = date('Y-m-d');
        $count = FichaPaciente::where('dni', '=', $request->dni)->where('fecha', '=', $fechaActual)->count();



        return ['existeficha' => $count, 'fecha' => $fechaActual, 'dni' => $request->dni];
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

    }


    public function buscarParaPrueba(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')

        /* $zap = PersonaZap::select('registro','puesto','gerencia','area')
       ->where('dni','like', '%'.$request->dni.'%')->get();*/
        $comprobante = Comprobante::select(
            'paciente.nombres',
            'paciente.apellido_materno',
            'paciente.apellido_paterno',
            'paciente.correo',
            'paciente.direccion',
            'paciente.telefono',
            'graldistritos.nombre as distrito',
            'gralprovincias.nombre as provincia',
            'graldepartamentos.nombre as departamento',
            'paciente.dni2 as dni'
        )
            ->leftjoin('graldistritos', 'graldistritos.iddistrito', '=', 'paciente.iddistrito')
            ->leftjoin('gralprovincias', 'gralprovincias.idprovincia', '=', 'paciente.idprovincia')
            ->leftjoin('graldepartamentos', 'graldepartamentos.iddepartamento', '=', 'paciente.iddepartamento')
            ->where('paciente.dni2', 'like', '%' . $request->dni . '%')->get();


        $mediweb = Paciente::select(
            'paciente.nombres',
            'paciente.apellido_materno',
            'paciente.apellido_paterno',
            'paciente.correo',
            'paciente.direccion',
            'paciente.telefono',
            'graldistritos.nombre as distrito',
            'gralprovincias.nombre as provincia',
            'graldepartamentos.nombre as departamento',
            'paciente.dni2 as dni'
        )
            ->leftjoin('graldistritos', 'graldistritos.iddistrito', '=', 'paciente.iddistrito')
            ->leftjoin('gralprovincias', 'gralprovincias.idprovincia', '=', 'paciente.idprovincia')
            ->leftjoin('graldepartamentos', 'graldepartamentos.iddepartamento', '=', 'paciente.iddepartamento')
            ->where('paciente.dni2', 'like', '%' . $request->dni . '%')->get();

        $query = DB::table('database1.table1 as dt1')->leftjoin('database2.table2 as dt2', 'dt2.ID', '=', 'dt1.ID');
        $output = $query->select(['dt1.*', 'dt2.*'])->get();

        //dd($categorias[0]);
        //$encodedData = json_encode($categorias, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_IGNORE);
        //dd($categorias);




        return ['paciente' => $mediweb];
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

    }



    public function ListarDepartamento(Request $request)
    {

        $dep = DepartamentoPeru::all();
        return ['departamento' => $dep];
    }
    public function ListarProvincia(Request $request)
    {

        $prov = Provincia::all();
        return ['provincia' => $prov];
    }
    public function ListarDistrito(Request $request)
    {

        $dist = Distrito::all();
        return ['distrito' => $dist];
    }
    public function ListarEmpresa(Request $request)
    {

        $empresa = Empresa::all();
        return ['empresa' => $empresa];
    }






    public function ListarPaciente(Request $request)
    {

        $categorias = Paciente::select(DB::raw('concat(paciente.nombres," ",paciente.apellidos) as nombre'))
            ->get();
        return ['paciente' => $categorias];
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')
        /*$categorias = Paciente::select('paciente.nombres','paciente.apellidos','paciente.correo','paciente.direccion','paciente.telefono',
       'graldistritos.nombre as distrito','gralprovincias.nombre as provincia','graldepartamentos.nombre as departamento')
       ->leftjoin('graldistritos','graldistritos.iddistrito', '=', 'paciente.iddistrito')
       ->leftjoin('gralprovincias','gralprovincias.idprovincia', '=', 'paciente.idprovincia')
       ->leftjoin('graldepartamentos','graldepartamentos.iddepartamento', '=', 'paciente.iddepartamento')  
       ->where('paciente.dni2','=', $request->dni)->first();
       //dd($categorias[0]);
       //$encodedData = json_encode($categorias, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_IGNORE);
      //dd($categorias);
      return ['paciente' => $categorias];*/
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

    }




    public function reporte(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        //Schema::connection('mysql2')
        $categorias = ExamenOcu::select('examenocu.idexamenocu', 'examenocu.descripcion')
            ->where('examenocu.codigo', 'LIKE', '%LAB%')
            ->get();
        //dd($categorias[0]);
        //$encodedData = json_encode($categorias, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_IGNORE);
        //dd($categorias);

        foreach ($categorias as $exam) {
            $id =  $exam->idexamenocu;

            $comprobante = Comprobante::where('estado', "=", '1')
                ->whereBetween('fecha', ['2019-03-01', '2020-03-31'])
                ->where(function ($query) use ($id) {
                    $query->where('servicio_atendidos', 'like', '%,' . $id . ',%')
                        ->orwhere('servicio_atendidos', 'like', $id . ',%')
                        ->orwhere('servicio_atendidos', 'like', '%,' . $id);
                })
                ->count();


            echo '<br>{ <br>
            "network": "' . $exam->descripcion . '",<br>
            "MAU":"' . $comprobante . '" <br>
        },<br>';
        }




        // return ['paciente' => $categorias];
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

    }

    public function selectSede(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categorias = Sede::where('condicion', '=', '1')
            ->select('id', 'descripcion')->orderBy('descripcion', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function listarPdf()
    {
        $categorias = Categoria::select('nombre', 'descripcion', 'condicion')->orderBy('nombre', 'asc')->get();
        $cont = Categoria::count();

        $pdf = \PDF::loadView('pdf.categoriaspdf', ['categorias' => $categorias, 'cont' => $cont])->setPaper('a4', 'portrait');
        return $pdf->download('categorias.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ubicacion = new Vecino();
        $ubicacion->dni = $request->dni;
        $ubicacion->nombres = $request->nombres;
        $ubicacion->apellido_paterno = $request->apellido_paterno;
        $ubicacion->apellido_materno = $request->apellido_materno;
        $ubicacion->condicion = '1';       
        $ubicacion->save();
    }*/


    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }


    public function iniciales($nombre)
    {
        $nombre = explode(" ", $nombre);
        $letras = "";
        foreach ($nombre as $v) {
            $letras .= "$v[0]";
        }
        return  strtoupper($letras);
    }






    public function CalcularDistancias(Request $request)
    {

        //$this->sendRequest($uri);



        echo $this->distance(-16.413301, -713545799, -16.421043, -71.553317, "K") . " Kilometers<br>";
    }


    public function BuscarFichaPaciente(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $fechaActual = date('Y-m-d');


        $categorias = FichaPaciente::where('dni', '=', $request->dni)
            ->where('fecha', '=', $fechaActual)
            ->first();
        return ['fichapaciente' => $categorias];
    }


    public function BuscarFichaPacientePruebaSerologica(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $estacion = $request->estacion;
        $fechaActual = date('Y-m-d');


        if ($criterio == 'nombre_completo') {

            $fichas = PruebaSerologica::select(
                'pruebaserologicas.created_at',
                'pruebaserologicas.idpruebaserologicas as id',
                'fichapacientes.codigo_ps',
                'pruebaserologicas.p1_react1gm',
                'pruebaserologicas.p1_reactigg',
                'pruebaserologicas.p1_reactigm_igg',
                'pruebaserologicas.no_reactivo',
                'pruebaserologicas.idfichapacientes',
                'pruebaserologicas.hora_inicio',
                'pruebaserologicas.hora_fin'
            )
                ->join('fichapacientes', 'pruebaserologicas.idfichapacientes', '=', 'fichapacientes.idficha_paciente')
                ->where('fichapacientes.id_estacion',$estacion)
                ->whereDate('pruebaserologicas.created_at',$fechaActual)
                ->orderBy('pruebaserologicas.created_at', 'DESC')
                ->get();

                //echo($fichas->count());
                $contador = $fichas->count() +1 ;

                foreach($fichas as $ficha)
                {
                    $contador = $contador -1 ;

                    $ficha->contador = $contador;

                }

        } else {



            $fichas = PruebaSerologica::select(
                'pruebaserologicas.created_at',
                'pruebaserologicas.idpruebaserologicas as id',
                'fichapacientes.codigo_ps',
                'pruebaserologicas.p1_react1gm',
                'pruebaserologicas.p1_reactigg',
                'pruebaserologicas.p1_reactigm_igg',
                'pruebaserologicas.no_reactivo',
                'pruebaserologicas.idfichapacientes',
                'pruebaserologicas.hora_inicio',
                'pruebaserologicas.hora_fin'
            )
                ->join('fichapacientes', 'pruebaserologicas.idfichapacientes', '=', 'fichapacientes.idficha_paciente')
                ->where('fichapacientes.id_estacion', '=', $criterio)
                ->where('fichapacientes.id_estacion',$estacion)
                ->orderBy('pruebaserologicas.created_at', 'DESC')
                ->get();
        
        }




        return [
            
            'fichas' => $fichas
        ];
    }

    public function BuscarCodigoPs(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');



        $id = $request->id;





        $fichas = FichaPaciente::where('codigo_ps', $id)
            ->orderBy('idficha_paciente', 'desc')
            ->first();




        return ['fichapaciente' => $fichas];
    }

    public function RegistrarPaciente(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechaActual = date('Y-m-d');
        $puntoatencion = "nada";
        $latitud_sermedi = -16.413301;
        $longitud_sermedi = -713545799;
        $latitud_complejo = -16.421043;
        $longitud_complejo = -71.553317;
        $latitud_chilina = -16.371362;
        $longitud_chilina = -71.534695;


        $latitud_casa = -16.365192;
        $longitud_casa = -71.516682;


        $latitud_tablet = $request->latitud;
        $longitud_tablet = $request->longitud;


        $distancia_con_sermedi = $this->distance($latitud_sermedi, $longitud_sermedi, $latitud_tablet,  $longitud_tablet, "K");
        $distancia_con_complejo = $this->distance($latitud_complejo, $longitud_complejo, $latitud_tablet,  $longitud_tablet, "K");
        $distancia_con_chilina = $this->distance($latitud_chilina, $longitud_chilina, $latitud_tablet,  $longitud_tablet, "K");
        $distancia_con_casa = $this->distance($latitud_casa, $longitud_casa, $latitud_tablet,  $longitud_tablet, "K");

        if ($distancia_con_sermedi < 2) {
            $puntoatencion = "SERMEDI";
        }
        if ($distancia_con_complejo < 2) {
            $puntoatencion = "COMPLEJO";
        }
        if ($distancia_con_chilina < 2) {
            $puntoatencion = "CHILINA";
        }
        if ($distancia_con_casa < 2) {
            $puntoatencion = "CASA";
        }


        $ubicacion = FichaPaciente::where('dni', $request->dni)
        ->where('fecha',$request->fechaActual)->first();

        if ($ubicacion === null) {
            $ubicacion = new FichaPaciente();
        }
        
       

        $ubicacion->dni = $request->dni;
        $ubicacion->nombre_completo = $request->nombre;
        $ubicacion->idempresa = $request->idempresa;
        $ubicacion->id_distrito = $request->iddistrito;
        $ubicacion->id_provincia = $request->idprovincia;
        $ubicacion->id_departamento = $request->iddepartamento;
        $ubicacion->direccion = $request->direccion;
        $ubicacion->telefono = $request->telefono;
        $ubicacion->idpaciente_mw = $request->idpaciente_mw;
        $ubicacion->puesto = $request->puesto;
        $ubicacion->gerencia = $request->gerencia;
        $ubicacion->area = $request->area;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->fecha = $fechaActual;
        $ubicacion->estado = 0;
        $ubicacion->puntoatencion = $puntoatencion;
        $ubicacion->idtipodocumento = $request->idtipodocumento;
        $ubicacion->area_mw = $request->area_mw;
        $ubicacion->puesto_mw = $request->puesto_mw;
        $ubicacion->numero_registro = $request->numero_registro;
        $ubicacion->empresa = $request->nombre_empresa;
        $ubicacion->id_estacion = $request->id_estacion;


        $nombre_completo_i = $request->nombre;
        $codigo =  $this->iniciales($nombre_completo_i);
        //$zap->codigops = $codigo;
        $dni_dos = substr($request->dni, strlen($request->dni) - 2, strlen($request->dni));




        $ubicacion->codigo_ps = $codigo . $dni_dos;

        $ubicacion->save();

        return response()->json(['fichacreada' => $ubicacion]);
    }


    public function PonerEstacion(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');


        //$ubicacion = new PruebaSerologica();
        $ubicacion = FichaPaciente::findOrFail($request->id_ficha_paciente);
        //Page::where('slug', '=', 'about')->firstOrFail();
        $ubicacion->id_estacion= $request->id_estacion;
        $ubicacion->save();

        $prueba= new PruebaSerologica();
        $prueba->idfichapacientes = $request->id_ficha_paciente;
        $prueba->save();








        return response()->json(['fichacreada' => $prueba]);
    }




    public function RegistrarDatosClinicos(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');


        $ubicacion = new DatosClinicos();
        $ubicacion->tos = $request->dc_tos;
        $ubicacion->dolor_garganta = $request->dc_dolor_garganta;
        $ubicacion->congestion_nasal = $request->dc_cong_nasal;
        $ubicacion->dificultad_respiratoria = $request->dc_dif_resp;
        $ubicacion->fiebre = $request->dc_fiebre;
        $ubicacion->malestar_general = $request->dc_malestar_general;
        $ubicacion->diarrea = $request->dc_diarrea;
        $ubicacion->nauseas_vomitos = $request->dc_nau_vom;
        $ubicacion->cefalea = $request->dc_cefalea;
        $ubicacion->irritabilidad_confusion = $request->dc_irr_conf;
        $ubicacion->falta_aliento = $request->dc_falta_aliento;
        $ubicacion->anosmia_ausegia = $request->dc_anosmia;
        $ubicacion->otros = $request->dc_otrossintomas;
        $ubicacion->toma_medicamento = $request->dc_toma_medicamento;
        $ubicacion->debilite_sistema = $request->dc_condicion_existente;
        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;


        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }


    public function RegistrarPruebaSerologica(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechaActual = date('d-m-Y H:i:s');
        //$ubicacion = new PruebaSerologica();
        $ubicacion = PruebaSerologica::findOrFail($request->id);
        //Page::where('slug', '=', 'about')->firstOrFail();
        $ubicacion->ps_llamada_113 = $request->ps_llamada_113;
        $ubicacion->ps_de_eess = $request->ps_de_eess;
        $ubicacion->ps_contactocasocon = $request->ps_cont_confirmado;
        $ubicacion->ps_contactocasosos = $request->ps_cont_sospechoso;
        $ubicacion->ps_personaext = $request->ps_pers_ext;
        $ubicacion->ps_personalsalud = $request->ps_per_salud;
        $ubicacion->ps_otro = $request->otrospsvalor;
        $ubicacion->p1_react1gm = $request->ps_igm;
        $ubicacion->p1_reactigg = $request->ps_igg;
        $ubicacion->p1_reactigm_igg = $request->ps_igmigg;
        $ubicacion->no_reactivo = $request->ps_no_reactivo;
        $ubicacion->invalido = $request->ps_invalido;
        $ubicacion->ccs = $request->ps_ccs;
        $ubicacion->condicion_riesgo_detalle = $request->pscondicionriesgovalor;
        $ubicacion->hora_fin = $fechaActual;        





        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;

        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }

    
    
    public function CrearPruebaSerologica(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechaActual = date('Y-m-d H:i:s');
        
        $prueba= new PruebaSerologica();
        $prueba->idfichapacientes = $request->id_ficha_paciente;
        $prueba->save();

        //$ubicacion = PruebaSerologica::findOrFail($request->id_prueba);


        //$ubicacion->hora_inicio = $fechaActual;
        

        $prueba->save();







        return response()->json(['fichacreada' => $prueba]);
    }
    
    
    
    
    public function IniciarPruebaSerologica(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechaActual = date('Y-m-d H:i:s');
        //$ubicacion = new PruebaSerologica();

        $ubicacion = PruebaSerologica::findOrFail($request->id_prueba);


        $ubicacion->hora_inicio = $fechaActual;
        

        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }

    public function TerminarPruebaSerologica(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $fechaActual = date('Y-m-d H:i:s');
        //$ubicacion = new PruebaSerologica();

        $ubicacion = PruebaSerologica::findOrFail($request->id_prueba);


        $ubicacion->hora_fin = $fechaActual;
        

        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }

    public function RegistrarAntecedentes(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');


        $ubicacion = new AntecedentesEp();


        $ubicacion->dias_viaje = $request->ae_14dias_viaje;
        $ubicacion->contacto_cercano = $request->ae_contacto_cercano;
        $ubicacion->conv_covid = $request->ae_conv_covid;
        $ubicacion->paises_visitados = $request->ae_paises_visitados;








        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;

        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }

    public function RegistrarTemperatura(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');


        $ubicacion = new Temperatura();


        $ubicacion->valortemp = $request->temperatura;









        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;

        $ubicacion->save();







        return response()->json(['fichacreada' => $ubicacion]);
    }
    public function RegistrarDeclaracionJurada(Request $request)
    {
        $imageName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/DJ'), $imageName);
        $ubicacion = new DeclaracionJurada();
        $ubicacion->path = $imageName;
        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();
    }

    public function RegistrarConsentimientoInformado(Request $request)
    {
        $imageName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/CI'), $imageName);
        $ubicacion = new ConsentimientoInformado();
        $ubicacion->path = $imageName;
        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();
    }

    public function RegistrarAnexoTres(Request $request)
    {
        $imageName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/ATRES'), $imageName);
        $ubicacion = new AnexoTres();
        $ubicacion->path = $imageName;
        $ubicacion->id_usuario = $request->usuario_id;
        $ubicacion->idfichapacientes = $request->id_ficha_paciente;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();
    }

    public function TerminarFicha(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $hora  = date('h:i:s ');

        $categoria = FichaPaciente::findOrFail($request->id_ficha);

        $categoria->hora_termino = $hora;
        $categoria->estado = '1';
        $categoria->save();

        return response()->json(['fichacreada' => $categoria]);
    }

    public function CargarEstados(Request $request)
    {
        $id = $request->id;
        $dc = DatosClinicos::where('idfichapacientes', '=', $id)->count();
        $ps_v = PruebaSerologica::where('idfichapacientes', '=', $id)->where('invalido', '=', 0)->count();
        $ps_i = PruebaSerologica::where('idfichapacientes', '=', $id)->where('invalido', '=', 1)->count();
        $ae = AntecedentesEp::where('idfichapacientes', '=', $id)->count();
        $temp = Temperatura::where('idfichapacientes', '=', $id)->count();
        $dj = DeclaracionJurada::where('idfichapacientes', '=', $id)->count();
        $ci = ConsentimientoInformado::where('idfichapacientes', '=', $id)->count();
        //echo $ps_i;

        return ['dc' => $dc, 'ps_v' => $ps_v, 'ps_i' => $ps_i, 'ae' => $ae, 'temp' => $temp, 'dj' => $dj, 'ci' => $ci];
        /*
      $mediweb= Paciente::select('paciente.nombres','paciente.apellido_materno','paciente.apellido_paterno','paciente.direccion',
      'paciente.telefono','graldistritos.nombre as distrito','gralprovincias.nombre as provincia','graldepartamentos.nombre as departamento',
      'paciente.dni2 as dni','paciente.correo as email')
       ->leftjoin('graldistritos','graldistritos.iddistrito', '=', 'paciente.iddistrito')
       ->leftjoin('gralprovincias','gralprovincias.idprovincia', '=', 'paciente.idprovincia')
       ->leftjoin('graldepartamentos','graldepartamentos.iddepartamento', '=', 'paciente.iddepartamento')  
       ->where('paciente.dni2','like', '%'.$request->dni.'%')->get();

       foreach($mediweb as $zap){
       $Paciente= PersonaZap::select('puesto','area','gerencia')
       ->where('num_documento','=', $request->dni)->get();
       foreach($Paciente as $datos_a){
           
         $zap->puesto = $datos_a['puesto']; 
         $zap->area = $datos_a['area']; 
         $zap->gerencia = $datos_a['gerencia']; 

       }
    }*/

        //dd($categorias[0]);
        //$encodedData = json_encode($categorias, JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_IGNORE);
        //dd($categorias);


        //dd($mediweb);

        // return ['paciente' => $mediweb];
        //$categorias = DB::connection('mysql2')->where('dni2','=','72815630')          
        //     ->get();
        //print($categorias[0]['attributes']);

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

    public function selectLote($id)
    {
        //if (!$request->ajax()) return redirect('/');
        $categorias = Lote::where('condicion', '=', '1')
            ->where('idmanzana', '=', $id)
            ->select('id', 'descripcion')->orderBy('descripcion', 'asc')->get();
        return ['lote' => $categorias];
    }
    public function BuscarDNI($dni)
    {
        //echo $dni;




        //OBTENEMOS EL VALOR
        //$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;

        //$consulta = file_get_html('https://eldni.com/buscar-por-dni?dni='.$dni);
        $consulta = HtmlDomParser::file_get_html('https://eldni.com/buscar-por-dni?dni=' . $dni);

        $datosnombres = array();
        foreach ($consulta->find('td') as $header) {
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
