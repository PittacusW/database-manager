<md-dialog ng-init="getData()" flex="90" flex-gt-md="75" style="max-height: 90%; max-width: 900px;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>@{{ model.id ? 'Editar' : 'Crear' }} Empresa</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form">
      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>business</md-icon>
        Detalles
      </md-subheader>
      <div class="md-padding">
        <div layout="row">
          <md-input-container class="md-block" flex>
            <label>RUT</label>
            <input type="text" name="rut" ng-model="model.rut" ng-rut required server-validation autofocus ng-readonly="model.id"/>
            @include('includes.messages', ['field' => 'rut'])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <label>Alias</label>
            <input type="text" name="alias" ng-model="model.alias" required server-validation ng-readonly="model.id"/>
            @include('includes.messages', ['field' => 'alias'])
          </md-input-container>
        </div>
        <md-input-container class="md-block" flex>
          <label>Dirección</label>
          <input type="text" name="direccion" ng-model="model.direccion" required server-validation/>
          @include('includes.messages', ['field' => 'direccion'])
        </md-input-container>
        <div layout="row">
          <md-input-container class="md-block" flex>
            <label>N° Resolución</label>
            <input type="number" name="nroResolucion" ng-model="model.nroResolucion" required server-validation/>
            @include('includes.messages', ['field' => 'nroResolucion'])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <md-datepicker md-hide-icons="calendar" name="fechaResolucion" ng-model="model.fechaResolucion" md-placeholder="Fecha Resolución*" md-open-on-focus="true" required server-validation></md-datepicker>
            @include('includes.messages', ['field' => 'fechaResolucion'])
          </md-input-container>
        </div>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>person</md-icon>
        Usuario Principal
      </md-subheader>
      <div class="md-padding" layout="row">
        <md-input-container class="md-block" flex>
          <label>RUT</label>
          <input type="text" name="root_rut" ng-model="model.root.rut" ng-rut required server-validation/>
          @include('includes.messages', ['field' => 'root_rut'])
        </md-input-container>
        <md-input-container class="md-block" flex>
          <label>Correo</label>
          <input type="email" name="root.email" ng-model="model.root.email" required server-validation/>
          @include('includes.messages', ['field' => 'root.email'])
        </md-input-container>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>group</md-icon>
        Representantes Legales
      </md-subheader>
      <div class="md-padding">
        <div layout="row" layout-align="start center" ng-repeat="representative in model.representatives track by $index">
          <md-input-container class="md-block" flex>
            <label>RUT</label>
            <input type="text" name="representative_rut" ng-model="model.representatives[$index]" ng-rut required server-validation/>
            @include('includes.messages', ['field' => 'representative_rut'])
          </md-input-container>
          <md-button class="md-icon-button" ng-click="addRepresentative()" ng-if="$last">
            <md-icon>add_box</md-icon>
          </md-button>
          <md-button class="md-icon-button" ng-click="removeRepresentative($index)" ng-if="!$last">
            <md-icon>indeterminate_check_box</md-icon>
          </md-button>
        </div>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>visibility</md-icon>
        Personalización
      </md-subheader>
      <div class="md-padding" layout="column" layout-xs="column" layout-sm="column" flex>
        <div layout="row" layout-xs="column" flex>
          <md-input-container class="md-block" flex>
            <label>Color Primario</label>
            <md-select name="colores.primary" ng-model="model.colores.primary" required server-validation>
              <md-optgroup ng-repeat="(color, variations) in colors.primary" label="@{{ color }}" md-colors="::{'background-color': 'default-'+color}">
                <md-option ng-repeat="variation in variations" ng-value="color+'.'+variation" md-colors="::{color: 'default-'+color+'-'+variation}" ng-style="::{'background-color': 'white'}">
                  <md-icon md-colors="::{color: 'default-'+color+'-'+variation}">lens</md-icon>
                  @{{ variation }}
                </md-option>
              </md-optgroup>
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'colores.primary'])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <label>Color Accent</label>
            <md-select name="colores.accent" ng-model="model.colores.accent" required server-validation>
              <md-optgroup ng-repeat="(color, variations) in colors.accent" label="@{{ color }}" md-colors="::{'background-color': 'default-'+color}">
                <md-option ng-repeat="variation in variations" ng-value="color+'.'+variation" md-colors="::{color: 'default-'+color+'-'+variation}" ng-style="::{'background-color': 'white'}">
                  <md-icon md-colors="::{color: 'default-'+color+'-'+variation}">lens</md-icon>
                  @{{ variation }}
                </md-option>
              </md-optgroup>
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'colores.accent'])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <label>Color Warn</label>
            <md-select name="colores.warn" ng-model="model.colores.warn" required server-validation>
              <md-optgroup ng-repeat="(color, variations) in colors.warn" label="@{{ color }}" md-colors="::{'background-color': 'default-'+color}">
                <md-option ng-repeat="variation in variations" ng-value="color+'.'+variation" md-colors="::{color: 'default-'+color+'-'+variation}" ng-style="::{'background-color': 'white'}">
                  <md-icon md-colors="::{color: 'default-'+color+'-'+variation}">lens</md-icon>
                  @{{ variation }}
                </md-option>
              </md-optgroup>
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'colores.warn'])
          </md-input-container>
        </div>
        <div layout="row" layout-sm="column" layout-xs="column">
          <div layout-align="center center" class="md-padding" style="width: 281px; max-width: 281px; min-width: 281px;" flex>
            <md-grid-list md-cols="1" md-row-height="1:1">
              <md-grid-tile class="area-thumb">
                <md-grid-tile-header class="grid-btn-upload">
                  <label for="logo-input-file" class="md-button md-raised md-icon-button" ng-disabled="isLoading">
                    <md-tooltip md-direction="bottom">Adjuntar logo</md-tooltip>
                    <md-icon>add_a_photo</md-icon>
                  </label>
                  <md-input-container md-no-float>
                    <input id="logo-input-file" name="file" type="file" accept="image/png" ngf-select ngf-max-size="2MB" ng-model="logo" class="ng-hide" server-validation/>
                    @include('includes.messages', ['field' => 'file'])
                  </md-input-container>
                </md-grid-tile-header>
                <md-icon class="md-48" ng-hide="logo || model.logo">photo</md-icon>
                <img class="image-thumb" ng-src="@{{ model.logo }}" ng-if="!logo && model.logo"/>
                <img class="image-thumb" ngf-thumbnail="logo" ng-if="logo"/>
              </md-grid-tile>
            </md-grid-list>
          </div>

          <div class="md-padding" flex>
            <div class="area-thumb">
              <md-toolbar class="md-table-toolbar md-default">
                <div layout="row" layout-align="center center" class="md-toolbar-tools">
                  <md-button class="md-icon-button">
                    <md-icon class="material-icons" md-colors="{'color': model.colores.primary ? 'default-'+model.colores.primary.replace('.', '-') : 'default-grey'}">menu</md-icon>
                  </md-button>
                  <img class="image-thumb" style="height: 30px;" ng-src="@{{ model.logo }}" ng-if="!logo && model.logo"/>
                  <img class="image-thumb" style="height: 30px;" ngf-thumbnail="logo" ng-if="logo"/>
                  <span flex></span>
                  <md-button class="md-icon-button">
                    <md-icon class="material-icons" md-colors="{'color': model.colores.accent ? 'default-'+model.colores.accent.replace('.', '-') : 'default-grey'}">exit_to_app</md-icon>
                  </md-button>
                </div>
              </md-toolbar>
              <md-card>
                <md-toolbar md-colors="{'background-color': model.colores.primary ? 'default-'+model.colores.primary.replace('.', '-') : 'default-grey'}">
                  <div class="md-toolbar-tools">
                    <span>Vista previa</span>
                  </div>
                </md-toolbar>
                <md-table-container>
                  <table md-table>
                    <thead md-head>
                      <tr md-row>
                        <th md-column class="text-center">Columna 1</th>
                        <th md-column class="text-center">Columna 2</th>
                        <th md-column class="text-center">Acciones</th>
                      </tr>
                    </thead>
                    <tbody md-body>
                      <tr md-row>
                        <td md-cell nowrap>Lorem ipsum</td>
                        <td md-cell nowrap>dolor sit amet</td>
                        <td md-cell>
                          <div layout="row" layout-align="center center">
                            <md-button class="md-icon-button">
                              <md-icon class="material-icons" md-colors="{'color': model.colores.accent ? 'default-'+model.colores.accent.replace('.', '-') : 'default-grey'}">edit</md-icon>
                            </md-button>
                            <md-button class="md-icon-button">
                              <md-icon class="material-icons" md-colors="{'color': model.colores.warn ? 'default-'+model.colores.warn.replace('.', '-') : 'default-grey'}">delete</md-icon>
                            </md-button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </md-table-container>
              </md-card>
            </div>
          </div>
        </div>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>view_module</md-icon>
        Contratación
      </md-subheader>
      <div class="md-padding">
        <md-input-container class="md-block">
          <label>Módulos y Planes</label>
          <md-select name="idPlans" ng-model="model.idPlans" multiple required server-validation>
            <md-optgroup ng-repeat="(module, plans) in plans" label="@{{ module }}">
              <md-option ng-repeat="plan in plans" ng-value="plan.id">@{{ plan.nombre }}</md-option>
            </md-optgroup>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'idPlans'])
        </md-input-container>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>chrome_reader_mode</md-icon>
        Certificación
      </md-subheader>
      <div class="md-padding">
        <md-input-container class="md-block">
          <label>Certificaciones</label>
          <md-select name="idCertifications" ng-model="model.idCertifications" multiple server-validation ng-disabled="!model.idPlans.length > 0">
            <md-optgroup ng-repeat="(type, certifications) in certifications" label="@{{ type }}">
              <md-option ng-repeat="certification in certifications" ng-value="certification.id" ng-disabled="model.idPlans.indexOf(certification.plan) < 0">@{{ certification.nombre }}</md-option>
            </md-optgroup>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'idCertifications'])
        </md-input-container>
      </div>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>