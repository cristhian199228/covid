<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <!-- <div class="card-header">
          <i class="fa fa-align-justify"></i> Pruebas Covid
          <!--<button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>

          <button type="button" @click="cargarPdf()" class="btn btn-info">
            <i class="icon-doc"></i>&nbsp;Reporte
          </button>
        </div>-->
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
                <div class="col-2 text-center">
                  <label class="form-control-label" for="text-input">ESTACIÓN</label>
                </div>
                <select class="form-control col-md-2" v-model="criterio">
                  <option value="11">COMPLEJO 1</option>
                  <option value="12">COMPLEJO 2</option>
                  <option value="13">COMPLEJO 3</option>
                  <option value="14">COMPLEJO 4</option>
                  <option value="15">COMPLEJO 5</option>
                  <option value="16">COMPLEJO 6</option>
                  <option value="17">COMPLEJO 7</option>
                  <option value="18">COMPLEJO 8</option>
                  <option value="19">COMPLEJO 9</option>
                  <option value="20">COMPLEJO 10</option>
                  <option value="1">CHILINA 1</option>
                  <option value="2">CHILINA 2</option>
                  <option value="3">CHILINA 3</option>
                  <option value="4">CHILINA 4</option>
                  <option value="5">CHILINA 5</option>
                  <option value="6">CHILINA 6</option>
                  <option value="7">JUAN PABLO 1</option>
                  <option value="8">JUAN PABLO 2</option>
                  <option value="9">JUAN PABLO 3</option>
                  <option value="10">JUAN PABLO 4</option>
                </select>
                <button
                  type="submit"
                  @click="listarAuto(1,buscar,'nombre_completo',criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
                <button
                  type="button"
                  @click="abrirModal('categoria','registrar')"
                  class="btn btn-secondary"
                >
                  <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Codigo</th>

                <!--<th>N° Registro</th>-->
                <th>Hora Inicio</th>
                <th>Tiempo</th>
                <th>Igm</th>
                <th>Igg</th>
                <th>Igm Igg</th>
                <th>Anexo 3</th>
                <th>Inicio/FIn</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                <td>
                  {{categoria.contador}} 
                </td>
                <td>
                  <h6>{{categoria.codigo_ps}}</h6>
                </td>
                <!-- <td v-text="categoria.idtipodocumento"></td>
                <td v-text="categoria.dni"></td>-->
                <!--<td v-text="categoria.numero_registro"></td>-->
                <td v-text="categoria.hora_inicio"></td>
                <!--<td v-text="categoria.puesto"></td>-->
                <td>
                  <time-ago
                    :refresh="5"
                    :datetime="categoria.hora_inicio"
                    :todo="()=>hola(categoria)"
                  ></time-ago>
                </td>

                <template v-if="categoria.p1_react1gm === 1">
                  <td class="bg-danger" v-text="categoria.p1_react1gm"></td>
                </template>
                <template v-else>
                  <td class="bg-success" v-text="categoria.p1_react1gm"></td>
                </template>

                <template v-if="categoria.p1_reactigg === 1">
                  <td class="bg-danger" v-text="categoria.p1_reactigg"></td>
                </template>
                <template v-else>
                  <td class="bg-success" v-text="categoria.p1_reactigg"></td>
                </template>

                <template v-if="categoria.p1_reactigm_igg === 1">
                  <td class="bg-danger" v-text="categoria.p1_reactigm_igg"></td>
                </template>
                <template v-else>
                  <td class="bg-success" v-text="categoria.p1_reactigm_igg"></td>
                </template>

                <td>
                  <label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      @change="AdjuntarAnexoTres(categoria)"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                  </label>
                </td>

                <template v-if="categoria.hora_inicio === null">
                  <button
                    type="button"
                    @click="TomarPrueba(categoria)"
                    class="btn btn-success btn-sm"
                  >
                    <i class="fa fa-play-circle"></i>
                  </button>
                </template>

                <template v-else-if="categoria.hora_inicio !== null && categoria.hora_fin === null">
                  <button
                    type="button"
                    @click="TomarPrueba(categoria)"
                    class="btn btn-danger btn-sm"
                  >
                    <i class="fa fa-stop-circle"></i>
                  </button>
                </template>
                <template v-else>
                  <td class="bg-success">COMPLETO</td>
                </template>
                <!-- <template v-else>
                  <td class="bg-success" v-text="categoria.p1_reactigm_igg"></td>
                </template>-->

                <!--<label class="switch switch-default switch-pill switch-info">
                    <input
                      type="checkbox"
                      class="switch-input"
                      checked
                      v-model="categoria.estado"
                      @change="TomarPrueba(categoria)"
                    />
                    <span class="switch-label"></span>
                    <span class="switch-handle"></span>
                </label>-->

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
                <label class="col-md-3 form-control-label" for="email-input">Introduzca Codigo</label>
                <div class="col-md-5">
                  <input
                    type="text"
                    v-model="codigo_buscar"
                    class="form-control"
                    placeholder="Ingrese Codigo"
                  />
                  <button type="button" @click="BuscarCodigoPs" class="btn btn-secondary">
                    <i class="fa fa-search"></i> Buscar
                  </button>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                <div class="col-md-9">
                  <input
                    type="email"
                    v-model="nombre_resultado"
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
              @click="IniciarPruebaSerologica()"
            >Iniciar Prueba</button>
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
import TimeAgo from "vue2-timeago";
export default {
  components: {
    TimeAgo
  },
  props: ["ruta"],
  data() {
    return {
      auto_id: 0,
      codigo_buscar: "",
      nombre_resultado: "",
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
      fc_estado: 0,
      diferencia: 0
    };
  },
  watch: {
    // cuando 'question' cambie, se ejecutará esta función
    categoria: function() {
      //navigator.vibrate(1000);

      var sound =
        "http://onj3.andrelouis.com/phonetones/unzipped/Meizu%20MX4/notifications/Meteor.mp3";
      var audio = new Audio(sound);
      console.log("hlaa");
      //audio.play();
      navigator.vibrate(2000);
    }
  },
  computed: {
    timestamp: function() {
      var dummyTicker = this.$data.ticker;

      var zone = moment().utcOffset();
      var time = moment.utc(this.$data.createdAt).utcOffset(zone);
      var formatted = time.format("HH:mm MMM Do") + ", " + time.fromNow();
      return formatted;
    },

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
    async PreguntarPosta() {
      const { value: fruit } = await this.$swal.fire({
        title: "Selecccione la estacion",
        input: "select",
        inputOptions: {
          1: "CHILINA 1",
          2: "CHILINA 2",
          3: "CHILINA 3",
          4: "CHILINA 4",
          5: "CHILINA 5",
          6: "CHILINA 6",
          7: "JUAN PABLO 1",
          8: "JUAN PABLO 2",
          9: "JUAN PABLO 3",
          10: "JUAN PABLO 4",
          11: "COMPLEJO 1",
          12: "COMPLEJO 2",
          13: "COMPLEJO 3",
          14: "COMPLEJO 4",
          15: "COMPLEJO 5",
          16: "COMPLEJO 6",
          17: "COMPLEJO 7",
          18: "COMPLEJO 8",
          19: "COMPLEJO 9",
          20: "COMPLEJO 10"
        },
        inputPlaceholder: "Seleccione una estación",
        showCancelButton: true
      });
      let me = this;
      if (fruit) {
        this.listarAuto(1, this.buscar, this.criterio, fruit);
        this.id_estacion = fruit
        this.criterio = fruit;
      }
    },

    hola(prueba) {
      var fechaEnMiliseg = Date.now();
      var date_2 = new Date(prueba.hora_inicio);
      var resultado = fechaEnMiliseg - date_2;
      var resultado_minutos = resultado / (1000 * 60);
      if (
        (resultado_minutos > 15 && resultado_minutos < 15.3) ||
        (resultado_minutos > 20 && resultado_minutos < 20.3)
      ) {
        var sound =
          "http://onj3.andrelouis.com/phonetones/unzipped/Meizu%20MX4/notifications/Meteor.mp3";
        var audio = new Audio(sound);

        audio.play();
        navigator.vibrate(2000);
      }

      console.log(resultado_minutos);
    },

    async AdjuntarAnexoTres(fichapaciente) {
      console.log(fichapaciente.idfichapacientes);

      const { value: file } = await this.$swal.fire({
        title: "Seleccionar imagen",
        input: "file",
        inputAttributes: {
          accept: "image/*",
          "aria-label": "Sube la foto"
        }
      });

      if (file) {
        /*
    Initialize the form data
  */
        let formData = new FormData();

        /*
    Add the form data we need to submit
  */
        formData.append("file", file);
        formData.append("id_ficha_paciente", fichapaciente.idfichapacientes);

        let me = this;

        const config = {
          headers: { "content-type": "multipart/form-data" },
          onUploadProgress: function(progressEvent) {
            me.uploadPercentage = Math.round(
              (progressEvent.loaded * 100) / progressEvent.total
            );
            console.log(this.uploadPercentage);
          }
        };

        // .post(this.ruta + "/temperatura/registrar", {

        axios
          .post(this.ruta + "/atres/registrar", formData, config)
          .then(function() {
            me.$swal.fire("La foto ha sido guardada!", "Gracias!", "success");
            me.arrayVecino = [];
            me.fichapaciente = 1;
            me.mostrarpruebas = 1;
            me.mostrarcamaradj = 0;
            me.uploadPercentage = 0;
            me.CargarEstados();
          })
          .catch(function() {
            console.log("FAILURE!!");
            me.uploadPercentage = 0;
          });
      }
    },

    playSound() {
      var sound =
        "http://soundbible.com/mp3/Air Plane Ding-SoundBible.com-496729130.mp3";
      var audio = new Audio(sound);
      audio.play();
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

    listarAuto(page, buscar, criterio,estacion) {
      let me = this;
       var url =
        this.ruta +
        "/listarPruebasSerologicas?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio +
        "&estacion=" +
        estacion;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayCategoria = respuesta.fichas;
         
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    listarAutoActualizar(page, buscar, criterio) {
      let me = this;
      var url =
        this.ruta +
        "/listarPruebas?page=" +
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
      console.log(fichapaciente);
      let me = this;
      if (fichapaciente.hora_inicio == null) {
        console.log("bulo");
        axios
          .put(this.ruta + "/iniciarprueba/", {
            id_prueba: fichapaciente.id
          })
          .then(function(response) {
            me.listarAuto(1, "", "nombre_completo",me.id_estacion);

            me.$swal.fire("Correcto", "Se ha iniciado la prueba!", "success");
          })
          .catch(function(error) {
            console.log(error);
          });
      } else {
        this.idpruebaserologica = fichapaciente.id;
        this.listarAuto(1, "", "nombre_completo",this.id_estacion);
        let me = this;
        me.open = true;
      }

      //
    },

    CondicionRiesgo() {
      if (this.ps_condicionriesgo == 1) {
        this.sipscondicionriesgo = 1;
      } else {
        this.sipscondicionriesgo = 0;
      }
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
      console.log("idpaciente" + this.idpaciente);
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
          id: this.idpruebaserologica,
          id_ficha_paciente: this.idpaciente,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire("Guardado!", "Se ha guardado la prueba!!!", "success");
          me.open = false;
          me.listarAuto(1, "", "nombre_completo",me.id_estacion);

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
          me.ps_no_reactivo = 0;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    IniciarPruebaSerologica() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      //let vueInstance = this; //This line is important
      //console.log(this.lat + "-" + this.lon);
      //console.log("sospecho" + this.ps_cont_sospechoso);
      axios
        .post(this.ruta + "/pruebaserologica/iniciar", {
          id_ficha_paciente: this.id_paciente_ps
        })
        .then(function(response) {
          me.$swal.fire("Guardado!", "Se ha creado la prueba!!!", "success");
          me.cerrarModal();
          me.listarAuto(1, "", "nombre_completo");
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

    BuscarCodigoPs() {
      let me = this;
      var url = this.ruta + "/BuscarCodigoPs/" + this.codigo_buscar;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          // console.log(respuesta.auto);
          //me.arrayAutoAsign = respuesta.paciente;
          me.nombre_resultado = respuesta.fichapaciente.nombre_completo;
          me.id_paciente_ps = respuesta.fichapaciente.idficha_paciente;

          console.log(respuesta);
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
              this.tituloModal = "Iniciar Prueba";
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
    //this.listarAuto(1, this.buscar, this.criterio);
    this.PreguntarPosta();
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
.container-fluid {
  width: 100%;
}
.main .container-fluid {
  padding: 0 0px;
}
.h6 {
  font-size: 1rem;
}
</style>
