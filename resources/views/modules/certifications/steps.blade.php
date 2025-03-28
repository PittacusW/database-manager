<md-dialog ng-init="getData()" flex="90" style="max-height: 90%; min-height: 90%;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Proceso de certificación para "@{{ business.alias }}"</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content layout="column" class="md-dialog-content" flex>
    <md-tabs md-center-tabs md-stretch-height flex>
      <md-tab label="Facturador electrónico">
        <md-stepper id="certification-stepper1" md-linear="true" md-alternative="false">

          <md-step md-label="Set de pruebas">
            <md-card layout-fill class="md-padding">
              <md-table-container flex>
                <table md-table md-progress="promise">
                  <thead md-head>
                    <tr md-row>
                      <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">@{{ column.name.toUpperCase() }}</th>
                    </tr>
                  </thead>
                  <tbody md-body>
                    <tr md-row ng-show="!certifications.length">
                      <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
                    </tr>
                    <tr md-row ng-repeat="certification in certifications">
                      <td md-cell nowrap>@{{ certification.nombre }}</td>
                      <td md-cell nowrap class="text-center">@{{ certification.pivot.trackId }}</td>
                      <td md-cell nowrap class="text-center">
                        <md-icon md-colors="{color: certification.pivot.status ? 'default-green' : 'default-red'}" ng-if="certification.pivot.trackId">
                          @{{ certification.pivot.status ? 'check' : 'remove' }}
                        </md-icon>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <pre>@{{ data }}</pre>
              </md-table-container>

              <md-card-actions layout="row" layout-align="end center">
                <div layout="row">
                  <label for="set-input-file" class="md-button md-raised md-accent" ng-disabled="isLoading">
                    <md-icon>file_upload</md-icon>
                    Seleccionar
                  </label>
                  <input id="set-input-file" name="file" type="file" class="ng-hide" accept=".txt" ngf-max-size="1MB" ng-model="file" ngf-select="upload()" required server-validation/>
                </div>
              </md-card-actions>
            </md-card>
          </md-step>

          <md-step md-label="Set de simulación">
            <md-card layout-fill class="md-padding"></md-card>
          </md-step>

          <md-step md-label="Intercambio de información">
            <md-card layout-fill class="md-padding"></md-card>
          </md-step>

          <md-step md-label="Muestras impresas">
            <md-card layout-fill class="md-padding"></md-card>
          </md-step>

          <md-step md-label="Declaración de cumplimiento">
            <md-card layout-fill class="md-padding"></md-card>
          </md-step>

          <md-step md-label="Finalizar">
            <md-card layout-fill class="md-padding"></md-card>
          </md-step>

        </md-stepper>
      </md-tab>
      {{--<md-tab label="Boletas electrónicas">
          <md-stepper id="certification-stepper2" md-linear="true" md-alternative="false">
              <md-step md-label="Set de pruebas">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Consumo de folios">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Envío de e-mail">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Declaración de cumplimiento">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Finalizar">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
          </md-stepper>
      </md-tab>
      <md-tab label="Libros electrónicos">
          <md-stepper id="certification-stepper3" md-linear="true" md-alternative="false">
              <md-step md-label="Envío obligatorio">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Envío de libros">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Declaración de término de pruebas">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
              <md-step md-label="Finalizar">
                  <md-card layout-fill class="md-padding">
                  </md-card>
              </md-step>
          </md-stepper>
      </md-tab>--}}
    </md-tabs>
  </md-dialog-content>

</md-dialog>