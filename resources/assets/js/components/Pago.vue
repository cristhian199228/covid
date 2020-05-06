<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <!--<div class="card-header">
          <div class="form-row">
            <div class="col-2 text-center">
              <label class="form-control-label" for="text-input">ESTACIÓN</label>
            </div>
            <div class="col-4">
              <select class="form-control col-md-2" v-model="estacion">
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
                <option value="7">CHILINA 7</option>
                <option value="8">CHILINA 8</option>
                <option value="9">CHILINA 9</option>
                <option value="10">CHILINA 10</option>
              </select>
            </div>
          </div>
        </div>-->
        <div class="card-body">
          <div class="form-row mb-3">
            <div class="col-1 text-center">
              <label class="form-control-label" for="text-input">DNI</label>
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
              <label class="form-control-label" for="text-input">NOMBRE</label>
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
              <label class="form-control-label" for="text-input">N° REGISTRO</label>
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
          </div>

          <div class="form-row mb-3">
            <div class="col">
              <input
                type="number"
                class="col-sm-auto form-control"
                id="validationCustomUsername"
                v-model="dni"
                placeholder="TEXTO A BUSCAR"
                v-on:keyup.enter="BuscarDNI(dni)"
              />
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="col text-center">
              <button type="button" @click="BuscarDNI(dni)" class="btn btn-info btn-sm">Buscar</button>
            </div>
          </div>

          <ul class="list-group">
            <li
              @click="onLongPressStart(vecino)"
              class="list-group-item d-flex justify-content-between align-items-center noselect"
              v-for="vecino in arrayVecino"
              :key="vecino.id"
            >
              <div class="row">
                <div class="col-auto">
                  {{ vecino.nombres }} {{ vecino.apellido_paterno }}
                  {{ vecino.apellido_materno }}
                </div>

                <div class="col-auto">
                  <h6>
                    <span class="badge badge-info badge-pill">
                      {{
                      vecino.empresa
                      }}
                    </span>
                  </h6>
                </div>
                <div class="col-auto">
                  <h6>
                    <span class="badge badge-info badge-pill">
                      {{
                      vecino.dni
                      }}
                    </span>
                  </h6>
                </div>
              </div>
            </li>
          </ul>

          <div class="container"></div>

          <nav
            class="navbar navbar-expand-lg navbar-light"
            style="background-color: #e3f2fd;"
            v-if="fichapaciente"
          >
            <a class="navbar-brand" v-text="this.fc_nombres" href="#"></a>

            <span class="badge badge-success float-right-noselect">
              <h4>{{codigo_ps}}</h4>
            </span>

            <!--<label class="switch switch-default switch-pill switch-info ml-12">
              <input
                type="checkbox"
                class="switch-input"
                v-model="this.fc_estado"
                @change="CompletarTodo()"
              />
              <span class="switch-label"></span>
              <span class="switch-handle"></span>
            </label>-->
          </nav>

          <br />

          <div v-if="this.mostrarpruebas">
            <div class="row">
              <div class="col-sm-6">
                <!--<div class="card" @click="abrircamaraci(vecino)">-->
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">CONCENTIMIENTO INFORMADO</h4>
                    <div class="container">
                      <div class="large-12 medium-12 small-12 cell">
                        <label>
                          Adjuntar Foto
                          <input
                            type="file"
                            id="file_ci"
                            ref="file_ci"
                            v-on:change="handleFileUpload_CI()"
                          />
                        </label>
                        <br />

                        <div class="progress">
                          <div
                            class="progress-bar"
                            role="progressbar"
                            :style="{width:uploadPercentage + '%'}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          >{{uploadPercentage}}</div>
                        </div>

                        <br />
                        <div class="text-center">
                          <button class="btn btn-primary" v-on:click="submitFile()">Enviar</button>
                          <!--<button type="submit" @click="CerrarCons" class="btn btn-warning">Atras</button>-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <!--<div class="card" @click="abrircamaradj(vecino)">-->
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">CUESTIONARIO DE TAMIZAJE</h4>

                    <div class="large-12 medium-12 small-12 cell">
                      <label>
                        Adjuntar Foto
                        <input
                          type="file"
                          id="file_dj"
                          ref="file_dj"
                          v-on:change="handleFileUpload_DJ()"
                        />
                      </label>
                      <br />

                      <div class="progress">
                        <div
                          class="progress-bar"
                          role="progressbar"
                          :style="{width:uploadPercentage2 + '%'}"
                          aria-valuemin="0"
                          aria-valuemax="100"
                        >{{uploadPercentage2}}</div>
                      </div>

                      <br />
                      <div class="text-center">
                        <button class="btn btn-primary" v-on:click="submitFileDj()">Enviar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <!-- <div class="card" @click="abrirtemp(vecino)">-->
                <div class="card no-select" @click="GuardarTemperatura">
                  <div class="card-body">
                    <h4 class="card-title">TEMPERATURA</h4>

                   
                  </div>
                  <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card" @click="abrirae(vecino)">
                  <div class="card-body">
                    <h4 class="card-title">ANTECEDENTES EPIDEMIOLOGICOS</h4>

                    <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="card noselect" @click="abrirdc(vecino)">
                  <div class="card-body">
                    <h4 class="card-title">DATOS CLINICOS ANAMNESIS</h4>

                    <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center">
              <button
                type="button"
                v-on:click="MandarEstacion()"
                class="btn btn-primary btn-lg"
              >Guardar</button>
            </div>
          </div>

          <div class="card" v-if="mostrardc">
            <div class="card-header">DATOS CLINICOS ANAMNESIS</div>
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">TOS</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_tos"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">DOLOR DE GARGANTA</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_dolor_garganta"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">CONGESTION NASAL</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_cong_nasal"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">DIFICULTAD RESPIRATORIA</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input type="checkbox" class="switch-input" checked v-model="dc_dif_resp" />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">FIEBRE</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input type="checkbox" class="switch-input" checked v-model="dc_fiebre" />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">MALESTAR GENERAL</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_malestar_general"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">DIARREA</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_diarrea"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">NAUSEAS Y VOMITOS</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_nau_vom"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">CEFALEA</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_cefalea"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-6 col-form-label"
                    >IRRITABILIDAD Y CONFUSION</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_irr_conf"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">FALTA DE ALIENTO</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_falta_aliento"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">ANOSMIA O AGEUSIA</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_anosmia"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">OTROS SINTOMAS</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_otros"
                          @change="otrosSintomas()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>

                    <br />
                    <input
                      type="email"
                      v-if="siotrossintomas"
                      v-model="otrossintomasvalor"
                      class="input-block-level"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                      placeholder="Escriba aqui otros Sintomas"
                    />
                  </div>

                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-6 col-form-label"
                    >TOMA ALGUN MEDICAMENTO PARA TRATAR ALGUN SINTOMA MENCIONADO</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_toma_medicamento"
                          @change="tomaMedicamento()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                    <input
                      type="email"
                      v-if="sitomamedicamento"
                      v-model="tomamedicamentovalor"
                      class="input-block-level"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                      placeholder="Escriba aqui los medicamentos"
                    />
                  </div>

                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-6 col-form-label"
                    >TIENE USTED ALGUNA CONDICION EXISTENTE QUE DEBILITE SU SISTEMA INMUNE</label>
                    <div class="col-sm-6">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="dc_condicion_existente"
                          @change="CondiconExistente()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                    <input
                      type="email"
                      v-if="sicondicionexistente"
                      v-model="condicionexistentevalor"
                      class="input-block-level"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                      placeholder="Escriba aqui los detalles"
                    />
                  </div>
                </form>
                <div class="text-center">
                  <button
                    type="submit"
                    @click="GuardarDatosClinicos"
                    class="btn btn-primary"
                  >Guardar</button>
                  <button type="button" class="btn btn-warning" @click="CerrarDatosClinicos">Atras</button>
                </div>
              </blockquote>
            </div>
          </div>

          <div class="card" v-if="mostrarps">
            <div class="card-header">PRUEBA SEROLOGICA</div>
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <h4 class="card-title">PROCEDENCIA DE SOLICITUD</h4>

                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-8 col-form-label">Llamada al 113</label>
                    <div class="col-sm-4">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_llamada_113"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-8 col-form-label">De EESS</label>
                    <div class="col-sm-4">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_de_eess"
                          @change="RegistroSi()"
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
                    >Contacto con caso confirmado</label>
                    <div class="col-sm-4">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_cont_confirmado"
                          @change="RegistroSi()"
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
                          @change="RegistroSi()"
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
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_pers_ext"
                          @change="RegistroSi()"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-8 col-form-label">Personal de salud</label>
                    <div class="col-sm-4">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_per_salud"
                          @change="RegistroSi()"
                        />
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
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ps_no_reactivo"
                        />
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
                  <button
                    type="button"
                    class="btn btn-warning"
                    @click="CerrarPruebaSerologica()"
                  >Atras</button>
                </div>
              </blockquote>
            </div>
          </div>

          <div class="card" v-if="mostrarae">
            <div class="card-header">ANTECEDENTES EPIDEMIOLOGICOS</div>
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <form>
                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-10 col-form-label"
                    >Durante los últimos 14 días ha estado residiendo o ha viajado desde cualquier país o área de Alto Riesgo.</label>
                    <div class="col-sm-2">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ae_14dias_viaje"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-10 col-form-label"
                    >¿Tuvo contacto cercano (compartiendo alojamiento o proporcionando cuidado)</label>
                    <div class="col-sm-2">
                      <label class="switch switch-default switch-pill switch-info">
                        <input
                          type="checkbox"
                          class="switch-input"
                          checked
                          v-model="ae_contacto_cercano"
                        />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-10 col-form-label"
                    >¿Pasó tiempo en la distancia de conversación con una persona que tiene o está bajo investigación por COVID-19?</label>
                    <div class="col-sm-2">
                      <label class="switch switch-default switch-pill switch-info">
                        <input type="checkbox" class="switch-input" checked v-model="ae_conv_covid" />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      for="staticEmail"
                      class="col-sm-6 col-form-label"
                    >Enumere todos los países y lugares donde ha residido o viajado en los últimos 14 días (incluso si no está afectado por COVID-19)</label>
                    <div class="col-sm-6">
                      <input
                        type="email"
                        v-model="ae_paises_visitados"
                        class="input-block-level"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Escriba aqui los detalles"
                      />
                    </div>
                  </div>
                </form>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click="GuardarAntecedentes()"
                  >Guardar</button>
                  <button
                    type="submit"
                    class="btn btn-warning"
                    @click="CerrarAntecedentesEpidemiologicos()"
                  >Atras</button>
                </div>
              </blockquote>
            </div>
          </div>
          <div class="card" v-if="mostrartemp">
            <div class="card-header">TEMPERATURA</div>
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">Toma de temperatura.</label>
                    <div class="col-sm-6">
                      <input
                        type="text"
                        v-model="temperatura"
                        class="form-control is-valid"
                        id="validationServer01"
                        value="36.6"
                        required
                      />
                    </div>
                  </div>
                </form>
                <div class="text-center">
                  <button type="submit" @click="GuardarTemperatura" class="btn btn-primary">Guardar</button>
                  <button type="submit" @click="CerrarTemperatura" class="btn btn-warning">Atras</button>
                </div>
              </blockquote>
            </div>
          </div>

          <div class="card" v-if="mostrarcamaracons">
            <div class="card-header">CONCENTIMIENTO INFORMADO</div>
            <div class="card-body">
              <div class="container">
                <div class="large-12 medium-12 small-12 cell">
                  <label>
                    Adjuntar Foto
                    <input
                      type="file"
                      id="file_ci"
                      ref="file"
                      v-on:change="handleFileUpload()"
                    />
                  </label>
                  <br />

                  <div class="progress">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :style="{width:uploadPercentage + '%'}"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    >{{uploadPercentage}}</div>
                  </div>

                  <br />
                  <div class="text-center">
                    <button class="btn btn-primary" v-on:click="submitFile()">Enviar</button>
                    <button type="submit" @click="CerrarCons" class="btn btn-warning">Atras</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card" v-if="mostrarcamaradj">
            <div class="card-header">CUESTIONARIO DE TAMIZAJE</div>
            <div class="card-body">
              <div class="large-12 medium-12 small-12 cell">
                <label>
                  Adjuntar Foto
                  <input
                    type="file"
                    id="file_ct"
                    ref="file"
                    v-on:change="handleFileUpload()"
                  />
                </label>
                <br />

                <div class="progress">
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{width:uploadPercentage + '%'}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  >{{uploadPercentage}}</div>
                </div>

                <br />
                <div class="text-center">
                  <button class="btn btn-primary" v-on:click="submitFileDj()">Enviar</button>
                  <button type="submit" @click="CerrarCons" class="btn btn-warning">Atras</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>

    <!--Inicio del modal agregar/actualizar
    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
    -->
    <vue-modaltor :visible="open" @hide="open = false" :show-close-button="false">
      <div class="mt-5">
        <div class="modal-header">
          <h4 class="modal-title">NUEVA PRUEBA</h4>
          <button type="button" class="close" @click="closeModal()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action method="post" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
            <div class="col-md-9">
              <input type="text" v-model="this.nombres_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">DNI</label>
            <div class="col-md-9">
              <input type="text" v-model="dni_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">EMPRESA</label>
            <div class="col-md-9">
              <v-select
                v-model="idempresa"
                :options="arrayEmp"
                label="descripcion"
                :value="idempresa"
              ></v-select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">DIRECCION</label>
            <div class="col-md-9">
              <input type="text" v-model="direccion_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">DEPARTAMENTO</label>
            <div class="col-md-9">
              <v-select v-model="iddepartamento" :options="arrayDep" label="nombre"></v-select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">PROVINCIA</label>
            <div class="col-md-9">
              <v-select v-model="idprovincia" :options="arrayPro" label="nombre"></v-select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">DISTRITO</label>
            <div class="col-md-9">
              <v-select
                v-model="iddistrito"
                :options="arrayDist"
                label="nombre"
                :value="iddistrito"
              ></v-select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">TELEFONO</label>
            <div class="col-md-9">
              <input type="text" v-model="telefono_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">EMAIL</label>
            <div class="col-md-9">
              <input type="text" v-model="email_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">PUESTO</label>
            <div class="col-md-9">
              <input type="text" v-model="puesto_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">GERENCIA</label>
            <div class="col-md-9">
              <input type="text" v-model="gerencia_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 form-control-label" for="text-input">AREA</label>
            <div class="col-md-9">
              <input type="text" v-model="area_a" class="form-control" placeholder />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="registrarModelo()">Guardar</button>
            <br />
            <br />
            <br />
          </div>

          <div v-show="errorMarca" class="form-group row div-error">
            <div class="text-center text-error">
              <div v-for="error in errorMostrarMsjMarca" :key="error" v-text="error"></div>
            </div>
          </div>
        </form>
      </div>
    </vue-modaltor>
    <div
      class="modal fade"
      id="exampleModalScrollable"
      :class="{ mostrar: modal }"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <!--<div class="modal-dialog modal-primary modal-lg" role="document">-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="registrarModelo()">Guardar</button>
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
import Multiselect from "vue-multiselect";

import moment from "moment";
import VueMonthlyPicker from "vue-monthly-picker";
import LongPress from "vue-directive-long-press";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VScrollLock from "v-scroll-lock";
Vue.use(VScrollLock);

export default {
  name: "Modal",
  props: ["ruta"],
  components: { Multiselect },
  components: {
    VueMonthlyPicker
  },
  directives: {
    "long-press": LongPress
  },

  data() {
    return {
      sede: "",
      estacion: "",
      file: "",
      file_ci: "",
      file_atres: "",
      uploadPercentage: 0,
      value: "",
      completo: "",
      name: "",
      area_mw: "",
      puesto_mw: "",
      fc_estado: 0,
      vecino: 0,
      idtipodocumento: 0,
      dc_tos: 0,
      dc_dolor_garganta: 0,
      dc_cong_nasal: 0,
      dc_dif_resp: 0,
      dc_fiebre: 0,
      dc_malestar_general: 0,
      dc_diarrea: 0,
      dc_nau_vom: 0,
      dc_cefalea: 0,
      dc_irr_conf: 0,
      dc_falta_aliento: 0,
      dc_anosmia: 0,
      dc_otros: 0,
      siotrossintomas: 0,
      otrossintomasvalor: "",
      dc_condicion_existente: 0,
      sicondicionexistente: 0,
      condicionexistentevalor: "",
      dc_toma_medicamento: 0,
      sitomamedicamento: 0,
      tomamedicamentovalor: "",

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

      ae_14dias_viaje: 0,
      ae_contacto_cercano: 0,
      ae_conv_covid: 0,
      ae_paises_visitados: "",

      temperatura: 36.6,

      mostrarcamaracons: 0,
      mostrarcamaradj: 0,
      image: "",

      dc_estado: 0,
      ae_estado: 0,
      ps_i: 0,
      ps_v: 0,
      temp: 0,
      ci_estado: 0,
      dj_estado: 0,

      open: false,
      plusInterval: null,
      minusInterval: null,
      value: [],
      options: [
        { name: "Enero", code: "01" },
        { name: "Febrero", code: "02" },
        { name: "Marzo", code: "03" },
        { name: "Abril", code: "04" },
        { name: "Mayo", code: "05" },
        { name: "Junio", code: "06" },
        { name: "Julio", code: "07" },
        { name: "Agosto", code: "08" },
        { name: "Setiembre", code: "09" },
        { name: "Octubre", code: "10" },
        { name: "Noviembre", code: "11" },
        { name: "Diciembre", code: "12" }
      ],
      meses: [
        "ene",
        "feb",
        "mar",
        "abr",
        "may",
        "jun",
        "jul",
        "ago",
        "sep",
        "oct",
        "nov",
        "dic"
      ],
      categoria_id: 0,
      id: 0,
      idpaciente_mw: 0,
      activo: false,
      nav_cabecera: "nav-link",
      nav_cabecera2: "nav-link active",
      nav_cuerpo: "tab-pane p-3",
      nav_cuerpo2: "tab-pane p-3 active",
      id_marca: 0,
      id_vecino: 0,
      es_departamento: 0,
      es_dni: 0,
      es_nombre: 0,
      fichapaciente: 0,
      mostrarpruebas: 0,
      mostrarps: 0,
      mostrarae: 0,
      mostrartemp: 0,
      mostrardc: 0,
      es_registro: 0,
      idproyecto: 0,
      descripcion: "",
      nombre_aside: "",
      nombres: "",
      nombres_a: "",
      dni_a: "",
      lat: 0,
      lon: 0,
      empresa_a: "",
      direccion_a: "",
      telefono_a: "",
      email_a: "",
      puesto_a: "",
      gerencia_a: "",
      area_a: "",
      idempresa_env: 0,
      iddistrito_env: 0,
      idprovincia_env: 0,
      iddepartamento_env: 0,
      placa_auto: "",
      fecha_pago: "",
      nro_recibo: "",
      id_recibo: "",
      monto: "",
      fc_nombres: "",
      fc_id: 0,
      apellido_paterno: "",
      apellido_materno: "",
      comentario: "",
      arrayCategoria: [],
      arrayMarca: [],
      arrayAuto: [],
      arrayAutoAsign: [],
      arrayLoteAsign: [],
      arrayDepaAsign: [],
      arrayVecino: [],
      arrayPago: [],
      arrayDep: [],
      arrayDist: [],
      arrayPro: [],
      arrayEmp: [],
      idempresa: 0,
      selectedMonth: moment(),
      selectedMonth2: moment(),
      modal: 0,
      nrecibo: 0,
      dni: "",
      tituloModal: "",
      tipoAccion: 0,
      errorMarca: 0,
      errorMostrarMsjMarca: [],
      idsede: 0,
      idlote: 0,
      idmanzana: 0,
      iddepartamento: 0,
      iddistrito: 0,
      idprovincia: 0,
      iddepartamento_id: 0,
      iddistrito_id: 0,
      idprovincia_id: 0,
      nombre_empresa: "",
      arraySede: [],
      arraySector: [],
      arrayLote: [],
      arrayDepartamento: [],
      codigo_ps: "",

      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "nombre",
      buscar: ""
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
    },
    total() {
      return this.arrayPago.map(function(pr) {
        return pr.recibo
          .map(q => q.monto * 1)
          .reduce(function(total, q) {
            return total + q;
          }, 0);
      });
    }
  },

  methods: {
    handleFileUpload_DJ() {
      console.log("abajo esta la imagen");

      console.log(this.$refs.file_dj.files[0]);
      this.file = this.$refs.file_dj.files[0];
    },
    handleFileUpload_CI() {
      console.log("abajo esta la imagen");
      console.log(this.$refs.file_ci.files[0]);
      this.file_ci = this.$refs.file_ci.files[0];
    },
    handleFileUpload_ATRES() {
      console.log("abajo esta la imagen");
      console.log(this.$refs.file_atres.files[0]);
      this.file_atres = this.$refs.file_atres.files[0];
    },
    async MandarEstacion() {
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
        axios
          .post(this.ruta + "/ficha/ponerestacion", {
            id_estacion: fruit,
            id_ficha_paciente: this.fc_id
          })
          .then(function(response) {
            me.$swal.fire(
              "Guardado!",
              "Se ha generado un registro!",
              "success"
            );
            me.dni = "";
            me.mostrarpruebas = 0;
            me.fichapaciente = 0;
            //console.log(me.fc_id + "-" + me.fc_nombres);
            // me.BuscarPersona(me.id);
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },

    submitFile() {
      /*
    Initialize the form data
  */
      let formData = new FormData();

      /*
    Add the form data we need to submit
  */
      formData.append("file", this.file_ci);
      formData.append("image", this.image);
      formData.append("usuario_id", this.$userId);
      formData.append("id_ficha_paciente", this.fc_id);
      formData.append("latitud", this.lat);
      formData.append("longitud", this.lon);

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
        .post(this.ruta + "/ci/registrar", formData, config)
        .then(function() {
          me.$swal.fire("La foto ha sido guardada!", "Gracias!", "success");
          me.arrayVecino = [];
          me.fichapaciente = 1;
          me.mostrarpruebas = 1;
          me.uploadPercentage = 0;
          me.mostrarcamaracons = 0;
          me.CargarEstados();
        })
        .catch(function() {
          console.log("FAILURE!!");
          me.uploadPercentage = 0;
        });
    },

    submitFileDj() {
      /*
    Initialize the form data
  */
      let formData = new FormData();

      /*
    Add the form data we need to submit
  */
      formData.append("file", this.file);
      formData.append("usuario_id", this.$userId);
      formData.append("id_ficha_paciente", this.fc_id);
      formData.append("latitud", this.lat);
      formData.append("longitud", this.lon);

      let me = this;

      const config = {
        headers: { "content-type": "multipart/form-data" },
        onUploadProgress: function(progressEvent) {
          me.uploadPercentage2 = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
          );
          console.log(this.uploadPercentage2);
        }
      };

      // .post(this.ruta + "/temperatura/registrar", {

      axios
        .post(this.ruta + "/dj/registrar", formData, config)
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
    },

    submitFileAtres() {
      /*
    Initialize the form data
  */
      let formData = new FormData();

      /*
    Add the form data we need to submit
  */
      formData.append("file", this.file_atres);
      formData.append("usuario_id", this.$userId);
      formData.append("id_ficha_paciente", this.fc_id);
      formData.append("latitud", this.lat);
      formData.append("longitud", this.lon);

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
    },

    CargarEstados() {
      let me = this;
      var url = this.ruta + "/cargarEstados/" + this.fc_id;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          // console.log(respuesta.auto);
          //me.arrayAutoAsign = respuesta.paciente;
          me.dc_estado = response.data.dc;
          me.ae_estado = response.data.ae;
          me.ps_v = response.data.ps_v;
          me.ps_i = response.data.ps_i;
          me.temp = response.data.temp;
          me.ci_estado = response.data.ci;
          me.dj_estado = response.data.dj;

          console.log(response.data);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    onImageChangeCi(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    onImageChangeDj(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag,
        idpago: this.id
      };
      this.options.push(tag);
      this.value.push(tag);
      console.log(tag);
    },

    abrircamaradj(vecino) {
      if (this.dj_estado == 1) {
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puede editar este registro",
          footer: "Comuniquese con el area de sistemas"
        });
      } else {
        this.$swal
          .fire({
            title: "Esta seguro?",
            text: "Subira una foto de la declaracion jurada!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si!"
          })
          .then(result => {
            if (result.value) {
              this.mostrarcamaradj = 1;
              this.mostrarpruebas = 0;
            }
          });
      }
    },

    abrircamaraci(vecino) {
      if (this.ci_estado == 1) {
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puede editar este registro",
          footer: "Comuniquese con el area de sistemas"
        });

        currentObj.arrayVecino = [];
        currentObj.fichapaciente = 1;
        currentObj.mostrarpruebas = 1;
        currentObj.mostrarcamaracons = 0;
        currentObj.CargarEstados();
      } else {
        this.$swal
          .fire({
            title: "Estaseguro?",
            text: "Subira una foto del concentimiento informado!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "SI!"
          })
          .then(result => {
            if (result.value) {
              this.mostrarcamaracons = 1;
              this.mostrarpruebas = 0;
            }
          });
      }
    },
    otrosSintomas() {
      if (this.dc_otros == 1) {
        this.siotrossintomas = 1;
      } else {
        this.siotrossintomas = 0;
      }
    },

    tomaMedicamento() {
      if (this.dc_toma_medicamento == 1) {
        this.sitomamedicamento = 1;
      } else {
        this.sitomamedicamento = 0;
      }
    },

    CondiconExistente() {
      if (this.dc_condicion_existente == 1) {
        this.sicondicionexistente = 1;
      } else {
        this.sicondicionexistente = 0;
      }
    },

    PsOtros() {
      if (this.ps_otros == 1) {
        this.siotrosps = 1;
      } else {
        this.siotrosps = 0;
      }
    },

    CondicionRiesgo() {
      if (this.ps_condicionriesgo == 1) {
        this.sipscondicionriesgo = 1;
      } else {
        this.sipscondicionriesgo = 0;
      }
    },

    onLongPressStart(paciente) {
      let me = this;
      this.area_mw = paciente.area_mw;
      this.puesto_mw = paciente.puesto_mw;
      this.nombre_empresa = paciente.empresa;

      var dni = paciente.dni;
      var url = this.ruta + "/buscar/ExisteRegistro/" + dni;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          console.log("existe ficha?" + respuesta);
          if (respuesta.existeficha > 0) {
            me.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Ya existe un registro , por favor ",
              footer: "revise en la pestaña revisar Pruebas!"
            });
          } else {
            me.$swal
              .fire({
                title: "Va a crear un nuevo registro?",
                text: "Por favor revise los datos a continuacion",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si , crear registro!"
              })
              .then(result => {
                if (result.value) {
                  me.open = true;

                  var url = this.ruta + "/buscar/DatosAdicionales/" + dni;
                  axios
                    .get(url)
                    .then(response => {
                      var respuesta = response.data;
                      // console.log(respuesta.auto);
                      me.arrayAutoAsign = respuesta.paciente;

                      me.nombres_a =
                        me.arrayAutoAsign[0].nombres +
                        " " +
                        me.arrayAutoAsign[0].apellido_paterno +
                        " " +
                        me.arrayAutoAsign[0].apellido_materno;
                      me.dni_a = me.arrayAutoAsign[0].dni;
                      me.idempresa = paciente.empresa;
                      me.idempresa_id = paciente.idempresa;
                      me.direccion_a = me.arrayAutoAsign[0].direccion;
                      me.iddepartamento = me.arrayAutoAsign[0].departamento;
                      me.iddistrito = me.arrayAutoAsign[0].distrito;
                      me.idprovincia = me.arrayAutoAsign[0].provincia;
                      me.iddepartamento_id =
                        me.arrayAutoAsign[0].departamento_id;
                      me.iddistrito_id = me.arrayAutoAsign[0].distrito_id;
                      me.idprovincia_id = me.arrayAutoAsign[0].provincia_id;
                      me.telefono_a = me.arrayAutoAsign[0].telefono;
                      me.email_a = me.arrayAutoAsign[0].email;
                      me.puesto_a = me.arrayAutoAsign[0].puesto;
                      me.gerencia_a = me.arrayAutoAsign[0].gerencia;
                      me.area_a = me.arrayAutoAsign[0].area;
                      me.idpaciente_mw = paciente.idpaciente;
                      me.idtipodocumento = me.arrayAutoAsign[0].tipodocumento;
                      me.numero_registro = me.arrayAutoAsign[0].registro;
                      me.codigo_ps = me.arrayAutoAsign[0].codigops;
                      /*
                       */
                      console.log("DATOS ADICIONALES");
                      console.log(response.data);
                    })
                    .catch(function(error) {
                      console.log(error);
                    });

                  /*Swal.fire(
      'Guardado!',
      'Los datos han sido guardados',
      'success'
    )*/
                }
              });
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    onLongPressStop() {
      // triggers on mouseup of document
    },
    abrirps() {
      // triggers on mouseup of document

      this.$swal
        .fire({
          title: "Va a tomar una prueba serologica?",
          text: "Esta Seguro?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, estoy seguro!"
        })
        .then(result => {
          if (result.value) {
            this.mostrarpruebas = 0;
            this.mostrarps = 1;
          }
        });
    },
    CerrarPruebaSerologica() {
      // triggers on mouseup of document
      this.mostrarpruebas = 1;
      this.mostrarps = 0;
    },
    abrirdc() {
      // triggers on mouseup of document
      if (this.dc_estado == 1) {
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puede editar este registro",
          footer: "Comuniquese con el area de sistemas"
        });
      } else {
        this.$swal
          .fire({
            title: "Va a crear datos CLinicos",
            text: "Esta seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, voy a crearlos!"
          })
          .then(result => {
            if (result.value) {
              this.mostrarpruebas = 0;
              this.mostrardc = 1;
            }
          });
      }
    },
    GuardarDc() {
      // triggers on mouseup of document
      this.mostrarpruebas = 1;
      this.mostrardc = 0;
    },
    abrirae() {
      // triggers on mouseup of document
      if (this.ae_estado == 1) {
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puede editar este registro",
          footer: "Comuniquese con el area de sistemas"
        });
      } else {
        this.$swal
          .fire({
            title: "Esta seguro?",
            text: "Va a guardar Antecedentes epidemiologicos",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si , estoy seguro"
          })
          .then(result => {
            if (result.value) {
              this.mostrarpruebas = 0;
              this.mostrarae = 1;
            }
          });
      }
    },
    GuardarAe() {
      // triggers on mouseup of document
      this.mostrarpruebas = 1;
      this.mostrarae = 0;
    },
    abrirtemp() {
      // triggers on mouseup of document

      if (this.temp == 1) {
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "No puede editar este registro",
          footer: "Comuniquese con el area de sistemas"
        });
      } else {
        this.$swal
          .fire({
            title: "Va a tomar una muestra de temperatura",
            text: "Esta seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, estoy seguro!"
          })
          .then(result => {
            if (result.value) {
              this.mostrarpruebas = 0;
              this.mostrartemp = 1;
            }
          });
      }
    },
    CerrarTemperatura() {
      // triggers on mouseup of document
      this.mostrarpruebas = 1;
      this.mostrartemp = 0;
    },
    closeModal() {
      this.open = false;
    },
    listarDepartamento() {
      //position.coords.latitude;

      let me = this;
      var url = this.ruta + "/listDep";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayDep = respuesta.departamento;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarProvincia() {
      let me = this;
      var url = this.ruta + "/listPro";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayPro = respuesta.provincia;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarDistrito() {
      let me = this;
      var url = this.ruta + "/listDist";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayDist = respuesta.distrito;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarEmpresa() {
      let me = this;
      var url = this.ruta + "/listEmp";
      axios
        .get(url)
        .then(function(response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayEmp = respuesta.empresa;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    DniSi() {
      /*if (this.validarMarca()){
                    return;
                }
                */
      if (this.es_dni == 1) {
        this.es_nombre = 0;
        this.es_registro = 0;
        this.dni = "";
      }
    },
    NombreSi() {
      if (this.es_nombre == 1) {
        this.es_dni = 0;
        this.es_registro = 0;
        this.dni = "";
      }
    },

    RegistroSi() {
      /*if (this.validarMarca()){
                    return;
                }
                */
      if (this.es_registro == 1) {
        this.es_nombre = 0;
        this.es_dni = 0;
        this.dni = "";
      }
    },

    listarAutoAsignado(id) {
      let me = this;
      //console.log(placa_auto);

      var url = this.ruta + "/auto/ListarAutoAsign/" + id;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          console.log(respuesta.auto);
          me.arrayAutoAsign = respuesta.auto;

          console.log(arrayAutoAsign);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    listarLoteAsignada(id) {
      let me = this;
      //console.log(placa_auto);

      var url = this.ruta + "/lote/ListarLoteAsign/" + id;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          //console.log(response.data);
          me.arrayLoteAsign = respuesta.lote;

          console.log(me.arrayLoteAsign);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    listarDepaAsignada(id) {
      let me = this;
      //console.log(placa_auto);

      var url = this.ruta + "/departamento/ListarDepaAsign/" + id;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          //console.log(response.data);
          me.arrayDepaAsign = respuesta.departamento;
          me.lote_abrev = console.log(me.arrayDepaAsign);
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cargarPdf() {
      window.open(this.ruta + "/persona/excel", "_blank");
    },

    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarDepartamento(page, buscar, criterio);
    },

    registrarModelo() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      this.$getLocation({
        enableHighAccuracy: false, //defaults to false
        timeout: Infinity, //defaults to Infinity
        maximumAge: 0 //defaults to 0
      }).then(coordinates => {
        this.lat = coordinates.lat;
        this.lon = coordinates.lng;
        console.log(coordinates);
      });

      if (
        typeof this.idempresa === "string" ||
        this.idempresa instanceof String
      ) {
        this.idempresa_env = this.idempresa_id;
        //console.log("array!!" + this.idempresa_id);
      } else {
        //console.log(this.idempresa);
        this.idempresa_env = this.idempresa.idempresa;
      }
      console.log(this.iddistrito);

      if (
        typeof this.iddistrito === "string" ||
        this.iddistrito instanceof String
      ) {
        this.iddistrito_env = this.iddistrito_id;
        console.log("array!!" + this.iddistrito_id);
      } else {
        this.iddistrito_env = this.iddistrito.iddistrito;
      }

      if (
        typeof this.idprovincia === "string" ||
        this.idprovincia instanceof String
      ) {
        this.idprovincia_env = this.idprovincia_id;
        //console.log("array!!" + this.idprovincia_id);
      } else {
        //console.log(this.idprovincia);
        this.idprovincia_env = this.idprovincia.idprovincia;
      }

      if (
        typeof this.iddepartamento === "string" ||
        this.iddepartamento instanceof String
      ) {
        this.iddepartamento_env = this.iddepartamento_id;
        //console.log("array!!" + this.iddepartamento_id);
      } else {
        //console.log(this.iddepartamento);
        this.iddepartamento_env = this.iddepartamento.iddepartamento;
      }

      let me = this;
      //let vueInstance = this; //This line is important
      console.log(this.lat + "-" + this.lon);
      axios
        .post(this.ruta + "/ficha/registrar", {
          nombre: this.nombres_a,
          idpaciente_mw: this.idpaciente_mw,
          dni: this.dni_a,
          idempresa: this.idempresa_env,
          direccion: this.direccion_a,
          iddistrito: this.iddistrito_env,
          idprovincia: this.idprovincia_env,
          iddepartamento: this.iddepartamento_env,
          puesto_mw: this.puesto_mw,
          area_mw: this.area_mw,
          telefono: this.telefono_a,
          email: this.email_a,
          puesto: this.puesto_a,
          gerencia: this.gerencia_a,
          area: this.area_a,
          latitud: this.lat,
          longitud: this.lon,
          usuario_id: this.$userId,
          idtipodocumento: this.idtipodocumento,
          numero_registro: this.numero_registro,
          nombre_empresa: this.nombre_empresa,
          id_estacion: this.estacion
        })
        .then(function(response) {
          me.open = false;
          //me.areamodel = response.data.fichacreada;
          //console.log(response.data.fichacreada);
          me.fc_nombres = response.data.fichacreada.nombre_completo;
          me.fc_id = response.data.fichacreada.idficha_paciente;
          me.fc_estado = response.data.fichacreada.estado;
          me.$swal.fire("Guardado!", "Se ha generado un registro!", "success");

          //console.log(me.fc_id + "-" + me.fc_nombres);
          // me.BuscarPersona(me.id);
        })
        .catch(function(error) {
          console.log(error);
        });

      this.arrayVecino = [];
      this.fichapaciente = 1;
      this.mostrarpruebas = 1;
    },

    GuardarDatosClinicos() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      //let vueInstance = this; //This line is important
      console.log(this.lat + "-" + this.lon);
      axios
        .post(this.ruta + "/datosclinicos/registrar", {
          dc_tos: this.dc_tos,
          dc_dolor_garganta: this.dc_dolor_garganta,
          dc_cong_nasal: this.dc_cong_nasal,
          dc_dif_resp: this.dc_dif_resp,
          dc_fiebre: this.dc_fiebre,
          dc_malestar_general: this.dc_malestar_general,
          dc_diarrea: this.dc_diarrea,
          dc_nau_vom: this.dc_nau_vom,
          dc_cefalea: this.dc_cefalea,
          dc_irr_conf: this.dc_irr_conf,
          dc_falta_aliento: this.dc_falta_aliento,
          dc_anosmia: this.dc_anosmia,
          dc_otrossintomas: this.otrossintomasvalor,
          dc_condicion_existente: this.condicionexistentevalor,
          dc_toma_medicamento: this.tomamedicamentovalor,
          id_ficha_paciente: this.fc_id,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire(
            "Guardado!",
            "Se han guardado los datos clinicos!",
            "success"
          );
          me.CargarEstados();
        })
        .catch(function(error) {
          console.log(error);
        });

      this.arrayVecino = [];
      this.fichapaciente = 1;
      this.mostrarpruebas = 1;
      this.mostrardc = 0;

      this.dc_tos = 0;
      this.dc_dolor_garganta = 0;
      this.dc_cong_nasal = 0;
      this.dc_dif_resp = 0;
      this.dc_fiebre = 0;
      this.dc_malestar_general = 0;
      this.dc_diarrea = 0;
      this.dc_nau_vom = 0;
      this.dc_cefalea = 0;
      this.dc_irr_conf = 0;
      this.dc_falta_aliento = 0;
      this.dc_anosmia = 0;
      this.dc_otros = 0;
      this.dc_toma_medicamento = 0;
      this.dc_condicion_existente = 0;
      this.otrossintomasvalor = "";
      this.condicionexistentevalor = "";
      this.tomamedicamentovalor = "";
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
          ps_igmigg: this.ps_igmigg,
          ps_no_reactivo: this.ps_no_reactivo,

          ps_invalido: this.ps_invalido,
          ps_ccs: this.ps_ccs,
          pscondicionriesgovalor: this.pscondicionriesgovalor,

          id_ficha_paciente: this.fc_id,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire("Guardado!", "Se ha guardado la prueba!!!", "success");
          me.CargarEstados();
        })
        .catch(function(error) {
          console.log(error);
        });

      this.arrayVecino = [];
      this.fichapaciente = 1;
      this.mostrarpruebas = 1;
      this.mostrarps = 0;

      this.ps_llamada_113 = 0;
      this.ps_de_eess = 0;
      this.ps_cont_confirmado = 0;
      this.ps_cont_sospechoso = 0;

      this.ps_pers_ext = 0;
      this.ps_per_salud = 0;
      this.otrospsvalor = "";
      this.ps_igm = 0;
      this.ps_igg = 0;
      this.ps_igmigg = 0;
      this.ps_invalido = 0;
      this.ps_ccs = 0;
      this.pscondicionriesgovalor = "";
    },

    CerrarDatosClinicos() {
      this.mostrarpruebas = 1;
      this.mostrardc = 0;
    },

    GuardarAntecedentes() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      let me = this;
      //let vueInstance = this; //This line is important
      console.log(this.lat + "-" + this.lon);
      console.log("sospecho" + this.ps_cont_sospechoso);
      axios
        .post(this.ruta + "/antecedentes/registrar", {
          ae_14dias_viaje: this.ae_14dias_viaje,
          ae_contacto_cercano: this.ae_contacto_cercano,
          ae_conv_covid: this.ae_conv_covid,
          ae_paises_visitados: this.ae_paises_visitados,

          id_ficha_paciente: this.fc_id,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire("Guardado!", "Se ha guardado la prueba!!!", "success");
          me.CargarEstados();
        })
        .catch(function(error) {
          console.log(error);
        });

      this.arrayVecino = [];
      this.fichapaciente = 1;
      this.mostrarpruebas = 1;
      this.mostrarae = 0;

      this.ae_14dias_viaje = 0;
      this.ae_contacto_cercano = 0;
      this.ae_conv_covid = 0;
      this.ae_paises_visitados = "";
    },

    CerrarAntecedentesEpidemiologicos() {
      this.mostrarpruebas = 1;
      this.mostrarae = 0;
    },

    async GuardarTemperatura() {
      /*if (this.validarMarca()){
                    return;
                }
                */


const { value: number } = await this.$swal.fire({
  title: 'Registrar Temperatura',
  input: 'text',
  
})

if (number) {
  //Swal.fire(`Entered email: ${email}`);
  let me = this;
      //let vueInstance = this; //This line is important
      //console.log(this.lat + "-" + this.lon);
      //console.log("sospecho" + this.ps_cont_sospechoso);
      axios
        .post(this.ruta + "/temperatura/registrar", {
          temperatura: number,

          id_ficha_paciente: this.fc_id,
          usuario_id: this.$userId,
          latitud: this.lat,
          longitud: this.lon
        })
        .then(function(response) {
          me.$swal.fire(
            "Guardado!",
            "Se ha guardado la Temperatura!!!",
            "success"
          );
          // me.CargarEstados();
        })
        .catch(function(error) {
          console.log(error);
        });

}
      

      

      this.arrayVecino = [];
      this.fichapaciente = 1;
      this.mostrarpruebas = 1;
      this.mostrartemp = 0;
    },

    GuardarDj(e) {
      /*if (this.validarMarca()){
                    return;
                }
                */

      e.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("usuario_id", this.$userId);
      formData.append("id_ficha_paciente", this.fc_id);
      formData.append("latitud", this.lat);
      formData.append("longitud", this.lon);
      // .post(this.ruta + "/temperatura/registrar", {

      axios
        .post(this.ruta + "/dj/registrar", formData, config)
        .then(function(response) {
          currentObj.success = response.data.success;
          currentObj.$swal.fire(
            "La foto ha sido guardada!",
            "Gracias!",
            "success"
          );
          currentObj.arrayVecino = [];
          currentObj.fichapaciente = 1;
          currentObj.mostrarpruebas = 1;
          currentObj.mostrarcamaradj = 0;
          currentObj.CargarEstados();
        })
        .catch(function(error) {
          currentObj.output = error;
        });

      this.image = "";
    },

    GuardarCons(e) {
      /*if (this.validarMarca()){
                    return;
                }
                */

      e.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" }
      };

      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("usuario_id", this.$userId);
      formData.append("id_ficha_paciente", this.fc_id);
      formData.append("latitud", this.lat);
      formData.append("longitud", this.lon);
      // .post(this.ruta + "/temperatura/registrar", {

      axios
        .post(this.ruta + "/ci/registrar", formData, config)
        .then(function(response) {
          currentObj.success = response.data.success;
          currentObj.$swal.fire(
            "La foto ha sido guardada!",
            "Gracias!",
            "success"
          );
          currentObj.arrayVecino = [];
          currentObj.fichapaciente = 1;
          currentObj.mostrarpruebas = 1;
          currentObj.mostrarcamaracons = 0;
          currentObj.CargarEstados();
        })
        .catch(function(error) {
          currentObj.output = error;
        });

      this.image = "";
    },

    CerrarCons() {
      this.mostrarpruebas = 1;
      this.mostrarcamaracons = 0;
    },
    CerrarDj() {
      this.mostrarpruebas = 1;
      this.mostrarcamaradj = 0;
    },

    CompletarTodo() {
      /*if (this.validarMarca()){
                    return;
                }
                */

      if (this.fc_estado == 0) {
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
              console.log("fichaaaa" + this.fc_id);
              axios
                .put(this.ruta + "/fichapaciente/terminar", {
                  id_ficha: this.fc_id,
                  fc_estado: 1
                })
                .then(function(response) {
                  me.fc_estado = response.data.fichacreada.estado;

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

      this.CargarEstados();
    },

    cargarAutos(data) {
      //console.log(data);
      Vue.nextTick(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
      document.getElementById("toglesidebar").click();
      this.nombre_aside =
        data.nombres +
        " " +
        data.apellido_paterno +
        " " +
        data.apellido_materno;
      this.id_vecino = data.id;
      this.listarAutoAsignado(data.id);
      this.nav_cabecera = "nav-link active";
      this.nav_cabecera2 = "nav-link";
      this.nav_cuerpo = "tab-pane p-3 active";
      this.nav_cuerpo2 = "tab-pane p-3";
    },

    cargarCasas(data) {
      //console.log(data);
      Vue.nextTick(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
      document.getElementById("toglesidebar").click();
      this.nombre_aside =
        data.nombres +
        " " +
        data.apellido_paterno +
        " " +
        data.apellido_materno;
      this.id_vecino = data.id;
      this.listarLoteAsignada(data.id);
      this.listarDepaAsignada(data.id);
      this.selectSector();
      this.nav_cabecera = "nav-link";
      this.nav_cabecera2 = "nav-link active";
      this.nav_cuerpo = "tab-pane p-3";
      this.nav_cuerpo2 = "tab-pane p-3 active";
    },

    cerrarAside(data) {
      //console.log(data);
      document.getElementById("toglesidebar").click();
      this.placa_auto = "";
      this.arrayAuto = [];
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
              me.listarDepartamento(1, "", "descripcion");
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
              me.listarDepartamento(1, "", "descripcion");
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

    selectDepartamento(proyecto) {
      let me = this;
      console.log("es:" + proyecto.id);
      var url = this.ruta + "/departamento/selectDepartamento/" + proyecto.id;
      axios
        .get(url)
        .then(function(response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayDepartamento = respuesta.departamento;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    chooseFiles(categoria) {
      document.getElementById("file_ci").click();
      this.ruta_xml = categoria.ruta_xml;
      this.idfactura_pdf = categoria.idfactura;
      //console.log(this.ruta_xml);
    },

    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.descripcion = "";
      this.comentario = "";
    },
    BuscarDNI(dni) {
      var criterio;
      this.fichapaciente = 0;
      this.mostrarpruebas = 0;
      if (this.es_dni == 1) {
        criterio = "dni";
      }
      if (this.es_nombre == 1) {
        criterio = "nombres";
      }
      if (this.es_registro == 1) {
        criterio = "registro";
      }

      console.log(criterio);

      this.nombres = "";
      this.correo = "";
      this.telefono = "";
      this.domicilio = "";
      let me = this;

      var url = this.ruta + "/paciente/buscar/" + dni + "/" + criterio;
      axios
        .get(url)
        .then(response => {
          var respuesta = response.data;
          me.arrayVecino = respuesta.paciente;
          console.log("aqui esta el area y demas");
          console.log(me.arrayVecino);
          /*this.nombres = me.arrayReniec.nombres+' '+me.arrayReniec.apellidos;
                    this.correo = me.arrayReniec.correo;
                    this.telefono = me.arrayReniec.telefono;
                    this.domicilio = me.arrayReniec.direccion+' '+me.arrayReniec.distrito+'-'+me.arrayReniec.provincia+'-'+me.arrayReniec.departamento;*/
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    abrirModal(modelo, accion, data = [], periodo = []) {
      switch (modelo) {
        case "categoria": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Nueva Prueba";
              this.monto = "";
              this.nro_recibo = "";
              this.periodo_inicio = "";
              this.fecha_pago = "";
              (this.selectedMonth = moment()),
                (this.selectedMonth2 = moment()),
                (this.tipoAccion = 1);
              break;
            }
            case "actualizar": {
              console.log("La data es :" + data["monto"]);
              this.modal = 1;
              this.id_recibo = data["idrecibo"];
              this.tituloModal = "Editar Pago";
              this.tipoAccion = 2;
              this.nro_recibo = data["nro_recibo"];
              this.monto = data["monto"];
              this.fecha_pago = data["fecha_pago"];
              this.activo = true;
              this.selectedMonth = periodo["periodo"];
              this.selectedMonth2 = periodo["periodo"];
              break;
            }
          }
        }
      }
    }
  },
  mounted() {
    this.listarDepartamento();
    this.listarProvincia();
    this.listarDistrito();
    this.listarEmpresa();
    console.log(this.$userId);
    this.$getLocation({
      enableHighAccuracy: false, //defaults to false
      timeout: Infinity, //defaults to Infinity
      maximumAge: 0 //defaults to 0
    }).then(coordinates => {
      this.lat = coordinates.lat;
      this.lon = coordinates.lng;
      console.log(coordinates);
    });
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.input-block-level {
  display: block;
  width: 100%;
  min-height: 28px;
  border: 1px solid #2f34c3;
}
.modal-content {
  width: 100% !important;
  position: absolute !important;

  max-height: 300px;
  overflow-y: scroll;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;

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
.custom-control-input:checked ~ .custom-control-label::before {
  color: #fff;
  border-color: #324998;
  background-color: #324998;
}
.custom-switch .custom-control-label::before {
  left: -2.25rem;
  width: 2.25rem;
  pointer-events: all;
  border-radius: 0.5rem;
}
.custom-control-label::before,
.custom-file-label,
.custom-select {
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out;
}
.custom-control-label::before {
  position: relative;
  top: 0.25rem;
  left: -1.5rem;
  display: block;
  width: 1rem;
  height: 1rem;
  pointer-events: none;
  content: "";
  background-color: #fff;
  border: #adb5bd solid 1px;
}
.custom-switch .custom-control-input:checked ~ .custom-control-label::after {
  background-color: #fff;
  -webkit-transform: translateX(1.25rem);
  transform: translateX(1.17rem);
}
.custom-switch .custom-control-label::after {
  top: calc(0.25rem + 2px);
  left: calc(-2.25rem + 2px);
  width: calc(1rem - 4px);
  height: calc(1rem - 4px);
  background-color: #adb5bd;
  border-radius: 0.5rem;
  transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
  transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out,
    -webkit-transform 0.15s ease-in-out;
}
.custom-control-label::after {
  position: absolute;
  top: 0.25rem;
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
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2196f3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196f3;
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
.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Opera and Firefox */
}
</style>
<
