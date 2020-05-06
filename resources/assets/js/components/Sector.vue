<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Pruebas Covid
          <!--<button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>-->

          <button type="button" @click="cargarPdf()" class="btn btn-info">
            <i class="icon-doc"></i>&nbsp;Reporte
          </button>
        </div>
        <div class="card-body">
          <!--<div class="form-row mb-3">
            <div class="col-1 text-center">
              <label class="form-control-label" for="text-input">CON SINTOMAS</label>
            </div>
            <div class="col-2">
              <label class="switch switch-default switch-pill switch-info">
                <input
                  type="checkbox"
                  class="switch-input"
                  checked
                  v-model="es_dni"
                  @change="DniSi()"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </div>

            <div class="col-3 text-center">
              <label class="form-control-label" for="text-input">PENDIENTES</label>
            </div>
            <div class="col-1">
              <label class="switch switch-default switch-pill switch-info">
                <input
                  type="checkbox"
                  class="switch-input"
                  checked
                  v-model="es_nombre"
                  @change="NombreSi()"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </div>

            <div class="col-3 text-center">
              <label class="form-control-label" for="text-input">SIN DATOS</label>
            </div>
            <div class="col-2">
              <label class="switch switch-default switch-pill switch-info">
                <input
                  type="checkbox"
                  class="switch-input"
                  checked
                  v-model="es_registro"
                  @change="RegistroSi()"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </div>
          </div>-->
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="nombre_completo">Nombre</option>
                  <option value="dni">DNI</option>
                  <option value="numero_registro">REGISTRO</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarAuto(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarAuto(1,buscar,criterio)"
                  class="btn btn-primary"
                >
                
                  <i class="fa fa-search"></i> Buscar
                </button>
                <button
                  type="submit"
                  @click="listarAuto(1,buscar,criterio)"
                  class="btn btn-info"
                >
                
                  <i class="fa fa-search"></i> Actualizar
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Nombres</th>
                <th>Tipo Doc</th>
                <th>DNI</th>
                <th>N° Registro</th>
                <th>Empresa</th>
                <th>Puesto</th>
                <th>DC</th>
                <th>AE</th>
                <th>T°</th>
                <th>PS</th>
                <th>FIN</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                <td v-text="categoria.nombre_completo"></td>
                <td v-text="categoria.idtipodocumento"></td>
                <td v-text="categoria.dni"></td>
                <td v-text="categoria.numero_registro"></td>
                <td v-text="categoria.empresa"></td>
                <td v-text="categoria.puesto"></td>
                

                <template v-if="categoria.anamnesis === 'SI'">
                  <td class="bg-danger" v-text="categoria.anamnesis"></td>
                </template>
                <template v-else-if="categoria.anamnesis === 'NO'">
                  <td class="bg-success" v-text="categoria.anamnesis"></td>
                </template>
                <template v-else>
                  <td v-text="categoria.anamnesis"></td>
                </template>

                <template v-if="categoria.antecedentesep === 'SI'">
                  <td class="bg-danger" v-text="categoria.antecedentesep"></td>
                </template>
                <template v-else-if="categoria.antecedentesep === 'NO'">
                  <td class="bg-success" v-text="categoria.antecedentesep"></td>
                </template>
                <template v-else>
                  <td v-text="categoria.antecedentesep"></td>
                </template>

                <template v-if="categoria.temperatura > 37.8">
                  <td class="bg-danger" v-text="categoria.temperatura"></td>
                </template>
                <template v-else-if="categoria.temperatura < 37.8">
                  <td class="bg-success" v-text="categoria.temperatura"></td>
                </template>
                <template v-else>
                  <td v-text="categoria.temperatura"></td>
                </template>

                <template v-if="categoria.pruebaSerologica === 'SI'">
                  <td
                    @click="TomarPrueba(categoria)"
                    class="bg-danger"
                    v-text="categoria.pruebaSerologica"
                  ></td>
                </template>
                <template v-else-if="categoria.pruebaSerologica === 'NO'">
                  <td
                    @click="TomarPrueba(categoria)"
                    class="bg-success"
                    v-text="categoria.pruebaSerologica"
                  ></td>
                </template>
                <template v-else>
                  <td @click="TomarPrueba(categoria)" v-text="categoria.pruebaSerologica"></td>
                </template>
                <td >
                <label class="switch switch-default switch-pill switch-info">
                <input
                  type="checkbox"
                  class="switch-input"
                  checked
                  v-model="categoria.estado"
                  @change="Terminar(categoria)"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
              </td>

                <!--<td>
                                        <div v-if="categoria.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>                                        
                </td>-->
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                >Ant</a>
              </li>
              <li
                class="page-item"
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page,buscar,criterio)"
                  v-text="page"
                ></a>
              </li>
              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                >Sig</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>

    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Placa</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="placa"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Marca</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="marca"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Modelo</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="modelo"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Color</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="color"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Serie</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="serie"
                    class="form-control"
                    placeholder="Ingrese descripción"
                  />
                </div>
              </div>
              <div v-show="errorMarca" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjMarca" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion==1"
              class="btn btn-primary"
              @click="registrarAuto()"
            >Guardar</button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizarAuto()"
            >Actualizar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <vue-modaltor :visible="open" @hide="open = false" :show-close-button="false">
      <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <h4 class="card-title">PROCEDENCIA DE SOLICITUD</h4>

            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">Llamada al 113</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_llamada_113" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">De EESS</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_de_eess" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="staticEmail"
                  class="col-sm-8 col-form-label"
                >Contacto con caso confirmado</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      checked
                      v-model="ps_cont_confirmado"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="staticEmail"
                  class="col-sm-8 col-form-label"
                >Contacto con caso sospechoso</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      checked
                      v-model="ps_cont_sospechoso"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="staticEmail"
                  class="col-sm-8 col-form-label"
                >Persona extranjero (migraciones)</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_pers_ext" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">Personal de salud</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_per_salud" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">Otros</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      checked
                      v-model="ps_otros"
                      @change="PsOtros()"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>

              <input
                type="email"
                v-if="siotrosps"
                v-model="otrospsvalor"
                class="input-block-level"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Escriba aqui los detalles"
              />
            </form>

            <h4 class="card-title">Resultado de la PRUEBA</h4>

            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">REACTIVO IgM</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_igm" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">REACTIVO IgG</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_igg" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">REACTIVO IgM/IgG</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_igmigg" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">NO REACTIVO</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_no_reactivo" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>

              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">INVALIDO</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input type="checkbox" class="switch-input" checked v-model="ps_invalido" />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
            </form>

            <h4 class="card-title">CLASIFICACION CLINICA DE SEVERIDAD</h4>

            <form>
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-8 col-form-label">Clasificacion</label>
                <div class="col-sm-4">
                  <select
                    v-if="sipscondicionriesgo"
                    v-model="ps_ccs"
                    class="form-control"
                    id="exampleFormControlSelect1"
                  >
                    <option>LEVE</option>
                    <option>MODERADO</option>
                    <option>SEVERO</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="staticEmail"
                  class="col-sm-8 col-form-label"
                >¿El paciente presenta alguna condición de riesgo?</label>
                <div class="col-sm-4">
                  <label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      checked
                      v-model="ps_condicionriesgo"
                      @change="CondicionRiesgo()"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </div>
              </div>
              <input
                type="email"
                v-if="sipscondicionriesgo"
                v-model="pscondicionriesgovalor"
                class="input-block-level"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Escriba aqui los detalles"
              />
            </form>
            <div class="text-center">
              <button
                type="submit"
                @click="GuardarPruebaSerologica()"
                class="btn btn-primary"
              >Guardar</button>
              <button type="button" class="btn btn-warning" @click="CerrarPruebaSerologica()">Atras</button>
            </div>
          </blockquote>
        </div>
      </div>
    </vue-modaltor>

    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modalQR}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input"></label>
                <div class="col-md-9">
                  <qr-code :text="qr_id"></qr-code>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModalQR()">Cerrar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </main>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      auto_id: 0,
      open: false,
      modalShown: false,
      qr_id: "",
      id_marca: 0,
      idproyecto: 0,
      descripcion: "",
      comentario: "",
      arrayCategoria: [],
      arrayMarca: [],
      modal: 0,
      modalQR: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorMarca: 0,
      errorMostrarMsjMarca: [],
      placa: "",
      marca: "",
      modelo: "",
      color: "",
      serie: "",

      idlote: 0,
      idmanzana: 0,
      arraySede: [],
      arraySector: [],
      arrayLote: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "nombre_completo",
      buscar: "",

      ps_llamada_113: 0,
      ps_de_eess: 0,
      ps_cont_confirmado: 0,
      ps_cont_sospechoso: 0,
      ps_pers_ext: 0,
      ps_per_salud: 0,
      ps_otros: 1,
      siotrosps: 1,
      otrospsvalor: "",
      ps_igm: 0,
      ps_igg: 0,
      ps_igmigg: 0,
      ps_no_reactivo: 0,
      ps_invalido: 0,
      ps_ccs: 0,
      ps_condicionriesgo: 0,
      sipscondicionriesgo: 0,
      pscondicionriesgovalor: "",
      id_paciente: 0,
      fc_estado:0,
      
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  methods: {
    registrarAuto() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      console.log(this.id_marca);
      axios
        .post(this.ruta + "/auto/registrar", {
          placa: this.placa,
          marca: this.marca,
          modelo: this.modelo,
          color: this.color,
          serie: this.serie
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarAuto(1, "", "descripcion");
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    listarAuto(page, buscar, criterio) {
      let me = this;
      var url =
        this.ruta +
        "/listarPruebasPendientes?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cargarPdf() {
      window.open(this.ruta + "/auto/excel", "_blank");
    },
    TomarPrueba(fichapaciente) {
      this.idpaciente = fichapaciente.idficha_paciente;
      let me = this;
 
this.$swal
        .fire({
          title: "Esta seguro ?",
          text: "Va a tomar una prueba",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si , estoy seguro"
}).then((result) => {
  if (result.value) {
    me.open = false ;
  }
})





        
    },

    CerrarPruebaSerologica() {
      // triggers on mouseup of document
      this.open = false;
    },

    Terminar(ficha) {
      /*if (this.validarMarca()){
                    return;
                }
                */

      if (ficha.estado == 1) {
        this.$swal
          .fire({
            title: "Esta seguro?",
            text: "Va a cerrar la atención!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "si, quiero Cerrarla!"
          })
          .then(result => {
            if (result.value) {
              let me = this;
              console.log("fichaaaa" + ficha.idficha_paciente);
              axios
                .put(this.ruta + "/fichapaciente/terminar", {
                  id_ficha: ficha.idficha_paciente,
                  fc_estado: 1
                })
                .then(function(response) {
                  me.fc_estado = response.data.fichacreada.estado;
                 me.listarAuto(1, "", "descripcion");

                  me.$swal.fire(
                    "Correcto",
                    "Se ha Cerrado la atencion!",
                    "success"
                  );
                })
                .catch(function(error) {
                  console.log(error);
                });
            }
          });
      } else {
        let me = this;
        me.fc_estado = 1;
        me.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puedes abrir la atencion!",
          footer: "Comunicate con el area de sistemas "
        });
      }
this.listarAuto(1, "", "descripcion");
    
    },

    GuardarPruebaSerologica() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      //let vueInstance = this; //This line is important
      console.log(this.lat + "-" + this.lon);
      console.log("sospecho" + this.ps_cont_sospechoso);
      axios
        .post(this.ruta + "/pruebaserologica/registrar", {
          ps_llamada_113: this.ps_llamada_113,
          ps_de_eess: this.ps_de_eess,
          ps_cont_confirmado: this.ps_cont_confirmado,
          ps_cont_sospechoso: this.ps_cont_sospechoso,

          ps_pers_ext: this.ps_pers_ext,
          ps_per_salud: this.ps_per_salud,

          otrospsvalor: this.otrospsvalor,
          ps_igm: this.ps_igm,
          ps_igg: this.ps_igg,
          ps_no_reactivo: this.ps_no_reactivo,
          ps_igmigg: this.ps_igmigg,
          ps_invalido: this.ps_invalido,
          ps_ccs: this.ps_ccs,
          pscondicionriesgovalor: this.pscondicionriesgovalor,

          id_ficha_paciente: this.idpaciente,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire("Guardado!", "Se ha guardado la prueba!!!", "success");
          me.open = false;
          me.listarAuto(1, "", "descripcion");

          me.ps_llamada_113 = 0;
          me.ps_de_eess = 0;
          me.ps_cont_confirmado = 0;
          me.ps_cont_sospechoso = 0;
          me.ps_pers_ext = 0;
          me.ps_per_salud = 0;
          me.ps_otros = 0;
          me.siotrosps = 0;
          me.otrospsvalor = "";
          me.ps_igm = 0;
          me.ps_igg = 0;
          me.ps_igmigg = 0;
          me.ps_invalido = 0;
          me.ps_ccs = 0;
          me.ps_condicionriesgo = 0;
          me.sipscondicionriesgo = 0;
          me.pscondicionriesgovalor = "";
          me.id_paciente = 0;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarAuto(page, buscar, criterio);
    },

    registrarAuto() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      console.log(this.id_marca);
      axios
        .post(this.ruta + "/auto/registrar", {
          placa: this.placa,
          marca: this.marca,
          modelo: this.modelo,
          color: this.color,
          serie: this.serie
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarAuto(1, "", "descripcion");
        })
        .catch(function(error) {
          console.log(error);
        });
    },

 PsOtros() {
      if (this.ps_otros == 1) {
        this.siotrosps = 1;
      } else {
        this.siotrosps = 0;
      }
    },

    actualizarAuto() {
      /*if (this.validarMarca()){
                    return;
                }
                */
      let me = this;
      console.log(this.auto_id);
      axios
        .put(this.ruta + "/auto/actualizar", {
          id: this.auto_id,
          placa: this.placa,
          marca: this.marca,
          modelo: this.modelo,
          color: this.color,
          serie: this.serie
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarAuto(1, "", "descripcion");
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    desactivarModelo(id) {
      swal({
        title: "Esta seguro de desactivar esta marca?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put(this.ruta + "/sede/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarAuto(1, "", "descripcion");
              swal(
                "Desactivado!",
                "El registro ha sido desactivado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    activarModelo(id) {
      swal({
        title: "Esta seguro de activar esta marca?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put(this.ruta + "/sede/activar", {
              id: id
            })
            .then(function(response) {
              me.listarAuto(1, "", "descripcion");
              swal(
                "Activado!",
                "El registro ha sido activado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },

    validarMarca() {
      this.errorMarca = 0;
      this.errorMostrarMsjMarca = [];

      if (!this.descripcion)
        this.errorMostrarMsjMarca.push(
          "El nombre de la Marca no puede estar vacío."
        );

      if (this.errorMostrarMsjMarca.length) this.errorMarca = 1;

      return this.errorMarca;
    },

    selectSector() {
      let me = this;
      var url = this.ruta + "/sector/selectSector";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arraySector = respuesta.proyectos;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    selectManzana(proyecto) {
      let me = this;
      console.log("es:" + proyecto.id);
      var url = this.ruta + "/manzana/selectManzana/" + proyecto.id;
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arraySede = respuesta.sede;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    selectLote(proyecto) {
      let me = this;
      console.log("es:" + proyecto.id);
      var url = this.ruta + "/lote/selectLote/" + proyecto.id;
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayLote = respuesta.lote;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.descripcion = "";
      this.comentario = "";
    },
    cerrarModalQR() {
      this.modalQR = 0;
      this.tituloModal = "";
      this.descripcion = "";
      this.comentario = "";
    },
    abrirModal(modelo, accion, data = []) {
      //document.getElementById('toglesidebar').click();
      switch (modelo) {
        case "categoria": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Auto";
              this.tipoAccion = 1;
              this.placa = "";
              this.marca = "";
              this.modelo = "";
              this.color = "";
              this.serie = "";
              break;
            }
            case "actualizar": {
              console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Auto";
              this.tipoAccion = 2;
              this.auto_id = data["id"];
              this.qr_id = String(data["id"]);
              this.placa = data["placa"];
              this.marca = data["marca"];
              this.modelo = data["modelo"];
              this.color = data["color"];
              this.serie = data["serie"];
              break;
            }
          }
        }
      }
    },
    abrirModalQR(modelo, accion, data = []) {
      switch (modelo) {
        case "categoria": {
          switch (accion) {
            case "registrar": {
              this.modalQR = 1;
              this.qr_id = String(data["id"]);
              this.tituloModal = "Ver QR";
              this.tipoAccion = 1;
              this.placa = "";
              this.marca = "";
              this.modelo = "";
              this.color = "";
              this.serie = "";
              break;
            }
          }
        }
      }
    }
  },
  mounted() {
    this.listarAuto(1, this.buscar, this.criterio);
  }
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
