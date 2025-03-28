<md-dialog flex="90" style="max-width: 600px;" ng-init="init()">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Editar Modelo</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form" ng-submit="save()">
      <md-input-container md-no-float class="md-block md-input-has-value">
        <label>Uses</label>
        <md-chips md-enable-chip-edit="true" md-add-on-blur="true" name="use" ng-model="model.lista_atributos[1]" ng-init="toArray(1)"></md-chips>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'use'])
      </md-input-container>
      <md-input-container class="md-block">
        <label>Extends</label>
        <input name="nombre" type="text" ng-model="model.lista_atributos[7]"/>
      </md-input-container>
      <md-input-container md-no-float class="md-block md-input-has-value">
        <label>Traits</label>
        <md-chips md-enable-chip-edit="true" md-add-on-blur="true" name="traits" ng-model="model.lista_atributos[2]" ng-init="toArray(2)"></md-chips>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'traits'])
      </md-input-container>
      <md-input-container class="md-block">
        <label>Campos Editables</label>
        <md-select name="fillable" ng-model="model.lista_atributos[4]" ng-init="toArray(4)" multiple server-validation>
          <md-option ng-repeat="column in columns" ng-value="column.id">@{{ column.name }}</md-option>
        </md-select>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'fillable'])
      </md-input-container>
      <md-input-container class="md-block">
        <label>Campos Ocultables</label>
        <md-select name="hidden" ng-model="model.lista_atributos[3]" ng-init="toArray(3)" multiple server-validation>
          <md-option ng-repeat="column in columns" ng-value="column.id">@{{ column.name }}</md-option>
        </md-select>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'hidden'])
      </md-input-container>
      <md-input-container md-no-float class="md-block md-input-has-value">
        <label>Campos Adicionales</label>
        <md-chips md-enable-chip-edit="true" md-add-on-blur="true" name="appends" ng-model="model.lista_atributos[5]" ng-init="toArray(5)"></md-chips>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'appends'])
      </md-input-container>
      <md-input-container class="md-block">
        <label>Cargar Relaciones</label>
        <md-select name="with " ng-model="model.lista_atributos[6]" ng-init="toArray(6)" multiple server-validation>
          <md-option ng-repeat="relation in model.lista_metodos | filter:{tipo_id: 3}" ng-value="hidden">@{{ relation.nombre }}</md-option>
        </md-select>
        <div class="md-errors-spacer"></div>
        @include('includes.messages', ['field' => 'with'])
      </md-input-container>
      <md-subheader>
        <div layout="row" layout-align="start center">
          <span flex>Métodos Personalizados</span>
          <md-button class="md-icon-button" ng-click="removeMethod()">
            <md-icon class="md-18">remove_circle</md-icon>
          </md-button>
          <md-button class="md-icon-button" ng-click="prevMethod()">
            <md-icon class="md-18">chevron_left</md-icon>
          </md-button>
          <span class="md-caption">@{{ (numMethod + 1) }}/@{{ model.lista_metodos.length }}</span>
          <md-button class="md-icon-button" ng-click="nextMethod()">
            <md-icon class="md-18">chevron_right</md-icon>
          </md-button>
          <md-button class="md-icon-button" ng-click="addMethod()">
            <md-icon class="md-18">add_circle</md-icon>
          </md-button>
        </div>
      </md-subheader>
      <div layout="column" class="md-padding" ng-if="!model.lista_metodos.length">
        <p class="md-caption">Sin metodos</p>
      </div>
      <div layout="column" class="md-padding" ng-if="model.lista_metodos.length">
        <md-input-container class="md-block">
          <label>Tipo</label>
          <md-select name="tipo_id" ng-model="model.lista_metodos[numMethod].tipo_id" ng-change="selectMethodType()" server-validation>
            @foreach($methodTypes->where('id', '<', 6) as $type)
              <md-option ng-value="{{ $type->id }}">{{ $type->nombre }}</md-option>
            @endforeach
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'tipo_funcion_id'])
        </md-input-container>
        <div layout="row" layout-align="start center">
          <md-input-container class="md-block" flex>
            <label>Acceso</label>
            <md-select name="acceso_id" ng-model="model.lista_metodos[numMethod].acceso_id" ng-disabled="model.lista_metodos[numMethod].tipo_id !== 1" server-validation>
              @foreach($methodAccess as $access)
                <md-option ng-value="{{ $access->id }}">{{ $access->nombre }}</md-option>
              @endforeach
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'acceso_id'])
          </md-input-container>
          <md-input-container class="md-block">
            <md-checkbox ng-model="model.lista_metodos[numMethod].estatico" ng-disabled="model.lista_metodos[numMethod].tipo_id !== 1">Estático</md-checkbox>
          </md-input-container>
        </div>
        <md-input-container class="md-block">
          <label>Nombre</label>
          <input name="nombre" type="text" ng-model="model.lista_metodos[numMethod].nombre"/>
        </md-input-container>
        <md-input-container md-no-float class="md-block md-input-has-value">
          <label>Parámetros</label>
          <md-chips md-enable-chip-edit="true" md-add-on-blur="true" name="parametros" ng-model="model.lista_metodos[numMethod].parametros" ng-disabled="model.lista_metodos[numMethod].tipo_id === 4 || model.lista_metodos[numMethod].tipo_id === 5"></md-chips>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'parametros'])
        </md-input-container>
        <md-input-container class="md-block md-input-has-value">
          <label>Contenido</label>
          <div ui-ace="editorCfg" style="margin-top: 10px; height: 200px;" ng-model="model.lista_metodos[numMethod].contenido"></div>
        </md-input-container>
      </div>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>