<md-dialog flex="90" flex-gt-md="75" style="max-width: 500px;" ng-init="init()">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Gestor de archivos en "@{{ business.alias }}"</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form">
      <div layout="row" class="md-padding">
        <md-radio-group ng-model="model.file_type" ng-change="selectType()" flex>
          <md-radio-button value="document">Documentos</md-radio-button>
          <md-radio-button value="certificate">Certificado Digital</md-radio-button>
          <md-radio-button value="test_folio">Folio de Prueba</md-radio-button>
        </md-radio-group>

        <div layout="column" layout-align="center stretch" class="md-padding" flex>

          <md-input-container class="md-block md-accent" ng-if="isType('certificate')" style="margin: 0;">
            <label>Contraseña</label>
            <input type="password" name="file_password" ng-model="model.file_password" required autofocus/>
            @include('includes.messages', ['field' => 'file_password'])
          </md-input-container>

          <div layout="row">
            <label for="file-input-file" class="md-button md-raised md-accent" ng-disabled="!model.file_type || isLoading" flex style="margin: 6px 0;">
              <md-icon>file_upload</md-icon>
              Seleccionar
            </label>
            <input id="file-input-file" name="file" type="file" class="ng-hide" accept="@{{ getTypeRules('accept') }}" ngf-select ngf-max-size="@{{ getTypeRules('size') || '1MB' }}" ng-model="file" required server-validation/>
          </div>

          <span class="md-caption" ng-show="model.file_type">Ext: @{{ getTypeRules('accept') }}, Máx: @{{ getTypeRules('size') }}.</span>

        </div>
      </div>

      <ul ng-show="errors" md-colors="{color: 'default-warn'}">
        <li ng-repeat="errors in errors" class="md-caption">@{{ errors[0] }}</li>
      </ul>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <div layout="row" ng-show="isLoading" flex>
      <md-progress-circular md-mode="determinate" md-diameter="30px" value="@{{ progress }}"></md-progress-circular>
      <span class="md-caption md-margin">@{{ progress }}%</span>
    </div>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>