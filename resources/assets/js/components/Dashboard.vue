<template>
            <main class="main">
            <aside class="aside-menu">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a :class='nav_cabecera' data-toggle="tab" href="#tab1" role="tab">
             Asignar Auto
          </a>
        </li>
         <li class="nav-item">
          <a :class='nav_cabecera2' data-toggle="tab"    href="#tab2" role="tab">
             Asignar Casa
          </a>
        </li>        
      </ul>
      <!-- Tab panes-->
      <div class="tab-content">
        <div :class='nav_cuerpo'  id="tab1" role="tabpanel">
            
            <div class="card">
<div class="card-header" v-text="this.nombre_aside"></div>
<div class="card-body">
    Autos Asignados
    
        <table class="table table-bordered table-striped table-sm">
        <tbody>
        <tr v-for="autosAsign in arrayAutoAsign" :key="autosAsign.id">
            
        <td > <button v-on:dblclick="LiberarAuto(autosAsign.id)" type="button"  v-text="autosAsign.placa" class="btn btn-outline-success btn-sm btn-block"></button></td>
        </tr>                                
        </tbody>
        </table>                          
</div>
</div>

            <div class="card">

<div class="card-body">
    Buscar Autos
    <div class="input-group">
                  
                  <input id="appendedInputButton" v-model="placa_auto"  size ="14" placeholder="Buscar PLACA"   type="text">
                  <span class="input-group-append">
                    <button type="button" @click="BuscarAuto()" class="btn btn-warning btn-sm">
        <i class="icon-magnifier"></i>
        </button>
                  </span>
                </div>
   
        <table class="table table-bordered table-striped table-sm">
        <tbody>
        
        <tr v-for="autos in arrayAuto" :key="autos.id">
        <td >
        <button v-on:dblclick="AsignarAuto(autos.id)" type="button" data-toggle="tooltip" title="hola" data-placement="left" v-text="autos.placa" class="btn btn-outline-primary btn-sm btn-block" data-original-title="Tooltip on left">Block level button</button>
        </td>
        </tr>                                
        </tbody>
        </table>
                           
</div>
</div>
<center><button type="button" @click="cerrarAside()" class="btn btn-danger btn-sm">Cerrar</button></center>
</div> 

<div :class='nav_cuerpo2'  id="tab2" role="tabpanel">
            
            <div class="card">
<div class="card-header" v-text="this.nombre_aside"></div>
<div class="card-body">
    Domicilios Asignados
    
        <table class="table table-bordered table-striped table-sm">
        <thead>
        <tr>
        <th>Lotes</th>                                                                      
        </tr>
        </thead>
        <tbody>
        <tr v-for="lotesAsign in arrayLoteAsign" :key="lotesAsign.id">
            
        <td > <button v-on:dblclick="LiberarLote(lotesAsign.id)" type="button"  v-text="lotesAsign.sectors_descripcion+'-'+lotesAsign.manzana_descripcion+'-'+lotesAsign.lote_descripcion" class="btn btn-outline-success btn-sm btn-block"></button></td>
        </tr>                                
        </tbody>
        </table>
        <table class="table table-bordered table-striped table-sm">
        <thead>
        <tr>
        <th>Departamentos</th>                                                                      
        </tr>
        </thead>
        <tbody>
        <tr v-for="depasAsign in arrayDepaAsign" :key="depasAsign.id">
            
        <td > <button v-on:dblclick="LiberarDepartamento(depasAsign.id)" type="button"  v-text="depasAsign.sectors_descripcion+'-'+depasAsign.manzana_descripcion+'-'+depasAsign.lote_descripcion+'-'+depasAsign.departamento_descripcion" class="btn btn-outline-success btn-sm btn-block"></button></td>
        </tr>                                
        </tbody>
        </table>
       


</div>
</div>

            <div class="card">
<div class="card-header">BUSCAR DOMICILIO</div>
<div class="card-body">
    <div class="form-group row">
        <label class="col-md-8 form-control-label" for="text-input">Departamento</label>
    <div class="col-md-4">
        <div class="custom-control custom-switch">
    <input type="checkbox" checked data-toggle="toggle" v-model="es_departamento" class="custom-control-input" id="switch1">
        <label class="custom-control-label" for="switch1"></label>
    </div>
    </div>
    </div>
    <div class="form-group">
    <label for="nf-email">Sector</label>
      <v-select v-model="idproyecto" :options="arraySector"  label="descripcion" @input="selectManzana(idproyecto)"></v-select>
    </div>
    <div class="form-group">
    <label for="nf-email">Manzana</label>
     <v-select v-model="idmanzana" :options="arraySede"  label="descripcion" @input="selectLote(idmanzana)" ></v-select> 
    </div>
    <div class="form-group">
    <label for="nf-email">Lote</label>
      <v-select v-model="idlote" :options="arrayLote"  label="descripcion" @input="selectDepartamento(idlote)"></v-select> 
    </div>
    <div class="form-group" v-show="this.es_departamento">
    <label for="nf-email">Departamento</label>
      <v-select v-model="iddepartamento" :options="arrayDepartamento"  label="descripcion" ></v-select> 
    </div>
    <center><button type="button" @click="AsignarDomicilio()" class="btn btn-success btn-sm">Asignar</button></center>
        <table class="table table-bordered table-striped table-sm">
        <tbody>        
        <tr v-for="autos in arrayAuto" :key="autos.id">
        <td >
        <button v-on:dblclick="AsignarAuto(autos.id)" type="button" data-toggle="tooltip" title="hola" data-placement="left" v-text="autos.placa" class="btn btn-outline-primary btn-sm btn-block" data-original-title="Tooltip on left">Block level button</button>
        </td>
        </tr>                                
        </tbody>
        </table>                           
</div>
</div>
<center><button type="button" @click="cerrarAside()" class="btn btn-danger btn-sm">Cerrar</button></center>
</div> 
        </div>
    </aside>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card text-center">
<div class="card-header">
IDENTIFICACIÓN DEL TRABAJADOR
</div>
<div class="card-body">

<form class="needs-validation" novalidate="">
<div class="form-row">

    
<div class="col-md-6 mb-3">
<label for="validationCustom01">DNI</label>
<div class="input-group">
<input type="number" class="form-control" id="validationCustomUsername" v-model="dni" >
                                        <button type="button" @click="BuscarDNI(dni)" class="btn btn-warning btn-sm">
                                            
                                          <i class="icon-magnifier"></i>
                                        </button>
</div>
</div>
<div class="col-md-6 mb-3">
<label for="validationCustom01">N° REGISTRO</label>
<div class="input-group">
<input type="number" class="form-control" id="validationCustomUsername" v-model="dni" >
                                        <!--<button type="button" @click="BuscarDNI(dni)" class="btn btn-warning btn-sm">
                                            
                                          <i class="icon-magnifier"></i>
                                        </button>-->
</div>
</div>
<div class="col-md-6 mb-3">
<label for="validationCustomUsername">NOMBRES</label>
<div class="input-group">
<input type="text" class="form-control" id="validationCustomUsername" v-model="nombres" aria-describedby="inputGroupPrepend" required="">

</div>
</div>
</div>

<div class="form-row">
<div class="col-md-4 mb-3">
<label for="validationCustom01">DOMICILIO</label>
<input type="text" class="form-control" id="validationCustom01" v-model="domicilio" required="">
</div>
<div class="col-md-4 mb-3">
<label for="validationCustomUsername">TELEFONO</label>
<div class="input-group">
<input type="text" class="form-control" id="validationCustomUsername" v-model="telefono" aria-describedby="inputGroupPrepend" required="">
</div>
</div>
<div class="col-md-4 mb-3">
<label for="validationCustomUsername">EMAIL</label>
<div class="input-group">
<input type="text" class="form-control" id="validationCustomUsername" v-model="correo" aria-describedby="inputGroupPrepend" required="">
</div>
</div>
</div>

<div class="form-row">
<div class="col-md-12 mb-3">
<label for="validationCustom01">PADRE O MADRE:(PARA EL CASO DE MENORES DE EDAD)</label>
<input type="text" class="form-control" id="validationCustom01" v-model="pom" required="">
</div>

</div>


</form>

</div>
</div>

<div class="card text-center">
<div class="card-header">
IDENTIFICACIÓN DEL BIEN CONTRATADO
</div>
<div class="card-body">

<form class="needs-validation" novalidate="">

<div class="form-row"> 
 <div class="col-sm">
         <div class="form-group row">
        <label class="col-md-3 form-control-label" for="text-input">PRODUCTO</label>
     <div class="col-md-3"> 
     <label class="switch switch-default switch-pill switch-primary">
    <input type="checkbox" class="switch-input" checked  v-model="producto"   @change="ProductoServicio()">
    <span class="switch-label"></span>
    <span class="switch-handle"></span>
</label>
    </div>
    </div>
</div>
    <div class="col-sm">
      <div class="form-group row">   
        <label class="col-md-3 form-control-label" for="text-input">SERVICIO</label>
     <div class="col-md-3"> 
     <label class="switch switch-default switch-pill switch-primary">
    <input type="checkbox" class="switch-input" checked  v-model="servicio"   @change="ServicioProducto()">
    <span class="switch-label"></span>
    <span class="switch-handle"></span>
</label>
    </div>
</div>
</div>

</div>

<div class="form-row">

    
<div class="col-md-6 mb-3">
<label for="validationCustom01">MONTO RECLAMADO</label>
<input type="text" class="form-control"  v-model="monto" id="validationCustom01"  required="">
</div>
<div class="col-md-6 mb-3">
<label for="validationCustomUsername">DESCRIPCIÓN</label>
<div class="input-group">
<input type="text" class="form-control"  v-model="descripcion" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required="">
</div>
</div>
</div>


   


</form>

</div>
</div>


<div class="card text-center">
<div class="card-header">
DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL COSUMIDOR
</div>
<div class="card-body">

<form class="needs-validation" novalidate="">

 <div class="form-row"> 
 <div class="col-sm">
         <div class="form-group row">
        <label class="col-md-3 form-control-label" for="text-input">RECLAMO<br>*RECLAMO: Disconformidad relacionada a los productos o servicios.</label>
     <div class="col-md-3"> 
     <label class="switch switch-default switch-pill switch-primary">
    <input type="checkbox" class="switch-input" checked  v-model="reclamo"    @change="ReclamoQueja()">
    <span class="switch-label"></span>
    <span class="switch-handle"></span>
</label>
    </div>
    </div>
</div>
    <div class="col-sm">
      <div class="form-group row">   
        <label class="col-md-3 form-control-label" for="text-input">QUEJA<br>*QUEJA: Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</label>
     <div class="col-md-3"> 
     <label class="switch switch-default switch-pill switch-primary">
    <input type="checkbox" class="switch-input" checked    v-model="queja"   @change="QuejaReclamo()">
    <span class="switch-label"></span>
    <span class="switch-handle"></span>
</label>
    </div>
</div>
</div>

</div>



    
<div class="form-row">
<div class="col-md-12 mb-3">
<label for="validationCustom01">DETALLE</label>
<textarea class="form-control" v-model="detalle"  id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

</div>

<div class="form-row">
<div class="col-md-12 mb-3">
<label for="validationCustom01">PEDIDO</label>
<textarea class="form-control"  v-model="pedido" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

</div>
<div class="form-row">
<div class="col-md-12 mb-3">

<button type="button" class="btn btn-primary" @click="Guardar()">Guardar</button>
</div>

</div>



  


</form>

</div>
</div>
                        <!--
                   
                
                 Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">DNI</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dni"  placeholder="Buscar RENIEC">
                                        <button type="button" @click="BuscarDNI()" class="btn btn-warning btn-sm">
                                            
                                          <i class="icon-magnifier"></i>
                                        </button>
                                        

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Ingrese Comentario">
                                        
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Paterno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido_paterno" class="form-control" placeholder="Ingrese Comentario">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido Materno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido_materno" class="form-control" placeholder="Ingrese Comentario">
                                        
                                    </div>
                                </div>

                                <div v-show="errorMarca" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjMarca" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarModelo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSede()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                categoria_id: 0,
                nav_cabecera :'nav-link',
                nav_cabecera2 :'nav-link active',
                nav_cuerpo :'tab-pane p-3', 
                nav_cuerpo2 :'tab-pane p-3 active', 
                id_marca:0,
                id_vecino:0,
                es_departamento:0,
                idproyecto:0,
                descripcion : '',
                nombre_aside : '',
                nombres : '',
                producto : 0,
                servicio : 0,
                reclamo : '',
                queja : '',
                domicilio : '',
                correo : '',
                telefono : '',
                pedido : '',
                detalle : '',
                monto : '',
                pom : '',
                placa_auto : '',
                apellido_paterno : '',
                apellido_materno : '',
                comentario : '',
                arrayCategoria : [],
                arrayMarca : [],
                arrayAuto : [],
                arrayAutoAsign : [],
                arrayLoteAsign : [],
                arrayDepaAsign : [],
                modal : 0,
                dni : '',
                tituloModal : '',
                tipoAccion : 0,
                errorMarca : 0,
                errorMostrarMsjMarca : [],
                idsede: 0, 
                idlote: 0, 
                idmanzana: 0,
                iddepartamento: 0,                
                arraySede : [],
                arraySector : [],
                arrayLote : [],
                arrayDepartamento : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {


            listarDepartamento (page,buscar,criterio){
                let me=this;
                var url=this.ruta + '/persona?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            listarAutoAsignado(id){
                
                
                let me=this;
                //console.log(placa_auto);
                
                var url= this.ruta + '/auto/ListarAutoAsign/'+id;
                axios.get(url).
               
                then(response => {
                    
                    var respuesta= response.data;
                    console.log(respuesta.auto);
                   me.arrayAutoAsign =respuesta.auto;
                   
                   console.log(arrayAutoAsign);
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarLoteAsignada(id){
                
                
                let me=this;
                //console.log(placa_auto);
                
                var url= this.ruta + '/lote/ListarLoteAsign/'+id;
                axios.get(url).
               
                then(response => {
                    
                    var respuesta= response.data;
                    //console.log(response.data);
                   me.arrayLoteAsign =respuesta.lote;
                  
                   
                   console.log(me.arrayLoteAsign);
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarDepaAsignada(id){
                
                
                let me=this;
                //console.log(placa_auto);
                
                var url= this.ruta + '/departamento/ListarDepaAsign/'+id;
                axios.get(url).
               
                then(response => {
                    
                    var respuesta= response.data;
                    //console.log(response.data);
                   me.arrayDepaAsign =respuesta.departamento;
                   me.lote_abrev = 
                   
                   console.log(me.arrayDepaAsign);
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cargarPdf(){
                window.open(this.ruta + '/persona/excel','_blank');
            },


            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarDepartamento(page,buscar,criterio);
            },


            registrarModelo(){
                /*if (this.validarMarca()){
                    return;
                }
                */
                
                let me = this;
                 console.log(this.id_marca);
                axios.post(this.ruta + '/persona/registrar',{
                    'dni': this.dni,
                    'nombres': this.nombres,
                    'apellido_paterno': this.apellido_paterno,
                    'apellido_materno': this.apellido_materno,
                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDepartamento(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                });
            },


            actualizarSede(){
               /*if (this.validarMarca()){
                    return;
                }
                */
                let me = this;
                 console.log(this.categoria_id);
                axios.put(this.ruta + '/persona/actualizar',{
                    'dni': this.dni,
                    'nombres': this.nombres,
                    'apellido_paterno': this.apellido_paterno,
                    'apellido_materno': this.apellido_materno,
                    'id': this.categoria_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDepartamento(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },

            cargarAutos(data){
               //console.log(data);
               Vue.nextTick(function () {
               $('[data-toggle="tooltip"]').tooltip()
               })
               document.getElementById('toglesidebar').click();
                this.nombre_aside = data.nombres+' '+data.apellido_paterno+' '+data.apellido_materno;
                this.id_vecino = data.id;
                this.listarAutoAsignado(data.id);
                this.nav_cabecera = 'nav-link active';
                this.nav_cabecera2 = 'nav-link';
                this.nav_cuerpo = 'tab-pane p-3 active'; 
                this.nav_cuerpo2 = 'tab-pane p-3'; 

               
            },
            
            cargarCasas(data){
               //console.log(data);
               Vue.nextTick(function () {
               $('[data-toggle="tooltip"]').tooltip()
               })
               document.getElementById('toglesidebar').click();
                this.nombre_aside = data.nombres+' '+data.apellido_paterno+' '+data.apellido_materno;
                this.id_vecino = data.id;
                this.listarLoteAsignada(data.id);
                this.listarDepaAsignada(data.id);
                this.selectSector();
                this.nav_cabecera = 'nav-link';
                this.nav_cabecera2 = 'nav-link active';
                this.nav_cuerpo = 'tab-pane p-3'; 
                this.nav_cuerpo2 = 'tab-pane p-3 active'; 

               
            },    

            cerrarAside(data){
               //console.log(data);
               document.getElementById('toglesidebar').click();
               this.placa_auto = "";
               this.arrayAuto = [];
                         

               
            }, 

            Guardar(){

                this.errorMostrarMsj =[];
                if (!this.nombres) this.errorMostrarMsj.push(" nombre ");
                if (!this.dni) this.errorMostrarMsj.push(" DNI ");
                if (!this.correo) this.errorMostrarMsj.push(" correo ");
                if (!this.telefono) this.errorMostrarMsj.push(" telefono ");
                if (!this.descripcion) this.errorMostrarMsj.push(" descripcion ");
                if (!this.detalle) this.errorMostrarMsj.push(" detalle ");
                if (!this.pedido) this.errorMostrarMsj.push(" pedido ");
                if(this.nombres == '' || this.dni == '' || this.correo == ''||this.telefono == '' || this.descripcion== '' || this.detalle == ''|| this.pedido == '' ){
                    
                //swal("Here's the title!", "...and here's the text!");
                swal("Por favor llenar lo siguientes campos :"," "+this.errorMostrarMsj);
                }
                else{
               swal({
                title: 'Desea Guardar el Registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta + '/sede/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDepartamento(1,'','descripcion');
                        swal(
                        'Guardado!',
                        'El registro ha sido guardado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
                }
            },
            activarModelo(id){
               swal({
                title: 'Esta seguro de activar esta marca?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta + '/sede/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDepartamento(1,'','descripcion');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarMarca(){
                this.errorMarca=0;
                this.errorMostrarMsjMarca =[];

                if (!this.descripcion) this.errorMostrarMsjMarca.push("El nombre de la Marca no puede estar vacío.");

                if (this.errorMostrarMsjMarca.length) this.errorMarca = 1;

                return this.errorMarca;
            },

             selectSector(){
                let me=this;
                var url= this.ruta + '/sector/selectSector';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arraySector= respuesta.proyectos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            selectManzana(proyecto){
                let me=this;
                console.log('es:'+proyecto.id);
                var url= this.ruta + '/manzana/selectManzana/'+proyecto.id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySede= respuesta.sede;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            selectLote(proyecto){
                let me=this;
                console.log('es:'+proyecto.id);
                var url= this.ruta + '/lote/selectLote/'+proyecto.id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayLote= respuesta.lote;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            

            selectDepartamento(proyecto){
                let me=this;
                console.log('es:'+proyecto.id);
                var url= this.ruta + '/departamento/selectDepartamento/'+proyecto.id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayDepartamento= respuesta.departamento;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            cerrarModal(){
                this.modal=0;
                this.tituloModal='';               
                this.descripcion='';
                this.comentario='';
            },
            BuscarDNI(dni){
                this.nombres = '';
                    this.correo = '';
                    this.telefono = '';
                    this.domicilio = '';
                let me=this;
                    
                var url= this.ruta + '/paciente/buscar/'+dni;
                axios.get(url).
                
                then(response => {

                    var respuesta= response.data;                    
                    me.arrayReniec =respuesta.paciente;
                    console.log(me.arrayReniec);
                    this.nombres = me.arrayReniec.nombres+' '+me.arrayReniec.apellidos;
                    this.correo = me.arrayReniec.correo;
                    this.telefono = me.arrayReniec.telefono;
                    this.domicilio = me.arrayReniec.direccion+' '+me.arrayReniec.distrito+'-'+me.arrayReniec.provincia+'-'+me.arrayReniec.departamento;
                    
                })
                .catch(function (error) {
                    console.log(error);
                    
                    
                });
                
                
            },
            BuscarAuto(){
                let me=this;
                var placa_auto = this.placa_auto;
                Vue.nextTick(function () {
               $('[data-toggle="tooltip"]').tooltip()
               })
                //console.log(placa_auto);
                
                var url= this.ruta + '/auto/BuscarAuto/'+placa_auto;
                axios.get(url).
                
                then(response => {
                    
                    var respuesta= response.data;
                    //console.log(respuesta.auto);
                   me.arrayAuto =respuesta.auto;
                   console.log(arrayAuto);
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
        
                
                
            },

                
            AsignarAuto(id){
               /*if (this.validarMarca()){
                    return;
                }
                */


                 swal({
                title: 'Esta seguro de asignar este Auto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(this.categoria_id);
                axios.put(this.ruta + '/auto/asignar',{
                    'id_vecino': this.id_vecino,
                    'id': id
                }).then(function (response) {
                     me.listarAutoAsignado(id_persona);
                     me.BuscarAuto();
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 




                
            },


             ProductoServicio(){
               /*if (this.validarMarca()){
                    return;
                }
                */
                if(this.producto == 1)
                this.servicio = 0;

                if(this.producto == 0)
                this.servicio = 1;

               
                
            },

            ServicioProducto(){
               /*if (this.validarMarca()){
                    return;
                }
                */
             
                if(this.servicio == 1)
                this.producto = 0;

                if(this.servicio == 0)
                this.producto = 1;
                
            },

            QuejaReclamo(){
               /*if (this.validarMarca()){
                    return;
                }
                */
                if(this.queja == 1)
                this.reclamo = 0;

                if(this.queja == 0)
                this.reclamo = 1;

               
                
            },

            ReclamoQueja(){
               /*if (this.validarMarca()){
                    return;
                }
                */
             
                if(this.reclamo == 1)
                this.queja = 0;

                if(this.reclamo == 0)
                this.queja = 1;
                
            },


            AsignarDomicilio(){
               /*if (this.validarMarca()){
                    return;
                }
                */
            if(this.es_departamento == 0)
            swal({
                title: 'Esta seguro de asignar este Domicilio?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(this.categoria_id);
                axios.post(this.ruta + '/lote/asignar',{
                    'id_persona': this.id_vecino,
                    'id_lote': this.idlote.id
                }).then(function (response) {
                     me.listarLoteAsignada(id_persona);
                     me.idproyecto = 0;
                     me.idmanzana = 0;
                     me.idlote = 0;
                     me.iddepartamento = 0;
                     me.selectSector();
                    
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            else
            swal({
                title: 'Esta seguro de asignar este Departamento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(this.categoria_id);
                axios.post(this.ruta + '/departamento/asignar',{
                    'id_persona': this.id_vecino,
                    'id_departamento': this.iddepartamento.id
                }).then(function (response) {
                     
                     me.listarDepaAsignada(id_persona);
                     me.idproyecto = 0;
                     me.idmanzana = 0;
                     me.idlote = 0;
                     me.iddepartamento = 0;
                     me.selectSector();
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 

                 




                
            },


            LiberarAuto(id){
               /*if (this.validarMarca()){
                    return;
                }
                */


                 swal({
                title: 'Esta seguro de liberar este Auto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(this.categoria_id);
                axios.put(this.ruta + '/auto/liberar',{
                    'id': id
                }).then(function (response) {
                     me.listarAutoAsignado(id_persona);
                     me.BuscarAuto();
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 




                
            },

            LiberarLote(id){
               /*if (this.validarMarca()){
                    return;
                }
                */


                 swal({
                title: 'Esta seguro de liberar este Lote?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(this.categoria_id);
                axios.put(this.ruta + '/lote/liberar',{
                    'id': id
                }).then(function (response) {
                     me.listarLoteAsignada(id_persona);
                   
                     
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 




                
            },


            LiberarDepartamento(id){
               /*if (this.validarMarca()){
                    return;
                }
                */


                 swal({
                title: 'Esta seguro de liberar este Departamento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                var id_persona =this.id_vecino
                 console.log(id);
                axios.put(this.ruta + '/departamento/liberar',{
                    'id': id
                }).then(function (response) {
                     me.listarDepaAsignada(id_persona);
                     
                     
                }).catch(function (error) {
                    console.log(error);
                }); 
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 




                
            },


            selectSector(){
                let me=this;
                var url= this.ruta + '/sector/selectSector';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arraySector= respuesta.proyectos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            selectManzana(proyecto){
                let me=this;
                console.log('es:'+proyecto.id);
                var url= this.ruta + '/manzana/selectManzana/'+proyecto.id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySede= respuesta.sede;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            selectLote(proyecto){
                let me=this;
                console.log('es:'+proyecto.id);
                var url= this.ruta + '/lote/selectLote/'+proyecto.id;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayLote= respuesta.lote;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "categoria":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Persona';
                                this.dni = '';                               
                                this.nombres = '';
                                this.apellido_paterno= '';
                                this.apellido_materno= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log('La data es :'+data['id']);
                                this.modal=1;
                                this.tituloModal='Actualizar Persona';
                                this.tipoAccion=2;
                                this.categoria_id=data['id'];
                                this.dni=data['dni'];
                                this.nombres= data['nombres'];
                                this.apellido_paterno= data['apellido_paterno'];
                                this.apellido_materno= data['apellido_materno'];
                                break;
                            }
                        }
                    }
                }
              
               
            }
        },
        mounted() {
            this.listarDepartamento(1,this.buscar,this.criterio);
        }
    }
   
</script>

<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    .custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top;
}
.custom-control-input {
    position: absolute;
    z-index: -1;
    opacity: 0;
}
.custom-switch {
    padding-left: 2.25rem;
}
.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
}
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #0b55c1;
    background-color: #0b55c1;
}
.custom-switch .custom-control-label::before {
    left: -2.25rem;
    width: 1.75rem;
    pointer-events: all;
    border-radius: .5rem;
}
.custom-control-label::before, .custom-file-label, .custom-select {
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.custom-control-label::before {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    background-color: #fff;
    border: #adb5bd solid 1px;
}
.custom-switch .custom-control-input:checked~.custom-control-label::after {
    background-color: #fff;
    -webkit-transform: translateX(.75rem);
    transform: translateX(.75rem);
}
.custom-switch .custom-control-label::after {
    top: calc(.25rem + 2px);
    left: calc(-2.25rem + 2px);
    width: calc(1rem - 4px);
    height: calc(1rem - 4px);
    background-color: #adb5bd;
    border-radius: .5rem;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
}
.custom-control-label::after {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
    background: no-repeat 50%/50% 50%;
}
switch {
              position: relative;
              display: inline-block;
              width: 60px;
              height: 34px;
            }
    .switch input { 
                  opacity: 0;
                  width: 0;
                  height: 0;
                }
    .slider {
                  position: absolute;
                  cursor: pointer;
                  top: 0;
                  left: 0;
                  right: 0;
                  bottom: 0;
                  background-color: #ccc;
                  -webkit-transition: .4s;
                  transition: .4s;
                }

    .slider:before {
                  position: absolute;
                  content: "";
                  height: 26px;
                  width: 26px;
                  left: 4px;
                  bottom: 4px;
                  background-color: white;
                  -webkit-transition: .4s;
                  transition: .4s;
                }

                input:checked + .slider {
                  background-color: #2196F3;
                }

                input:focus + .slider {
                  box-shadow: 0 0 1px #2196F3;
                }

                input:checked + .slider:before {
                  -webkit-transform: translateX(26px);
                  -ms-transform: translateX(26px);
                  transform: translateX(26px);
                }

                /* Rounded sliders */
        .slider.round {
                  border-radius: 34px;
                }

        .slider.round:before {
                  border-radius: 50%;
                }
        .aside-menu {
                z-index: 1019;
                right: 500;
                width: 250px;
                color: #29363d;
                background: #fff;
                border-left: 1px solid #c2cfd6;
                }
</style>
