<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Departamento
                        <button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="sectors.descripcion">Sector</option>
                                      <option value="manzanas.descripcion">Manzana</option>
                                      <option value="lotes.descripcion">Lote</option>
                                      <option value="departamentos.descripcion">Departamento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarDepartamento(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarDepartamento(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width ="100">Opciones</th>                                    
                                    <th>Sector</th>
                                    <th>Manzana</th>
                                    <th>Lote</th>
                                    <th>Departamento</th>
                                    <th>Comentario</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                    <td>
                                        <button type="button" @click="abrirModal('categoria','actualizar',categoria)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="categoria.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarModelo(categoria.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarModelo(categoria.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="categoria.desc_sec"></td>
                                    <td v-text="categoria.desc_man"></td>
                                    <td v-text="categoria.desc_lote"></td>
                                    <td v-text="categoria.desc_dep"></td>                                      
                                    <td v-text="categoria.comentario"></td>
                                    <td>
                                        <div v-if="categoria.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
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
                                    <label class="col-md-3 form-control-label" for="text-input">Sector (*)</label>
                                    <div class="col-md-9">
                                       <v-select v-model="idproyecto" :options="arraySector"  label="descripcion" @input="selectManzana(idproyecto)"></v-select>                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Manzana (*)</label>
                                    <div class="col-md-9">
                                       <v-select v-model="idmanzana" :options="arraySede"  label="descripcion" @input="selectLote(idmanzana)" ></v-select>                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Lote (*)</label>
                                    <div class="col-md-9">
                                       <v-select v-model="idlote" :options="arrayLote"  label="descripcion" ></v-select>                                      
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Comentario</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="comentario" class="form-control" placeholder="Ingrese descripción">
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
                id_marca:0,
                idproyecto:0,
                descripcion : '',
                comentario : '',
                arrayCategoria : [],
                arrayMarca : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMarca : 0,
                errorMostrarMsjMarca : [],
                idsede: 0, 
                idlote: 0, 
                idmanzana: 0,                
                arraySede : [],
                arraySector : [],
                arrayLote : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'departamentos.descripcion',
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
                var url=this.ruta + '/departamento?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },


            cargarPdf(){
                window.open(this.ruta + '/departamento/excel','_blank');
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
                axios.post(this.ruta + '/departamento/registrar',{
                    'descripcion': this.descripcion,
                    'comentario': this.comentario,
                    'idlote': this.idlote.id,
                   
                    
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
                axios.put(this.ruta + '/departamento/actualizar',{
                    'descripcion': this.descripcion,
                    'comentario': this.comentario,
                    'id': this.categoria_id,
                    'idlote': this.idlote.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDepartamento(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },


            desactivarModelo(id){
               swal({
                title: 'Esta seguro de desactivar esta marca?',
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
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            

            cerrarModal(){
                this.modal=0;
                this.tituloModal='';               
                this.descripcion='';
                this.comentario='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "categoria":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Departamento';                               
                                this.descripcion = '';
                                this.comentario= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log('La data es :'+data);
                                this.modal=1;
                                this.tituloModal='Actualizar Departamento';
                                this.tipoAccion=2;
                                this.categoria_id=data['id'];
                                this.descripcion= data['desc_dep'];
                                this.comentario= data['comentario'];
                                this.idproyecto= data['desc_sec'];
                                this.idmanzana= data['desc_man'];
                                this.idlote= data['desc_lote'];
                                break;
                            }
                        }
                    }
                }
                this.selectSector();
               
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
</style>
