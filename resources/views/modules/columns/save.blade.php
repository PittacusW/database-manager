<md-dialog flex="90" style="max-width: 600px;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>@{{ model.id ? 'Editar' : 'Crear' }} Columna</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form" ng-submit="save()">

      <md-subheader class="md-no-sticky">Descripción</md-subheader>
      <div layout="column" class="md-padding">
        <md-input-container class="md-block" flex>
          <label>Tipo</label>
          <md-select name="type" ng-model="model.type" ng-change="selectType()" server-validation>
            @foreach($types as $type)
              <md-option value="{{ $type['id'] }}">{{ $type['name'] }}</md-option>
            @endforeach
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'type'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Nombre</label>
          <input name="name" type="text" ng-model="model.name" required server-validation/>
          @include('includes.messages', ['field' => 'name'])
        </md-input-container>
        <div layout="row" ng-if="ifTypeIsNumber()">
          <md-input-container class="md-block" flex>
            <label>Precisión</label>
            <input name="precision" type="number" min="1" max="65" ng-model="model.precision" server-validation/>
            @include('includes.messages', ['field' => 'precision', 'min' => 1, 'max' => 65])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <label>Escala</label>
            <input name="scale" type="number" min="0" max="30" ng-model="model.scale" server-validation/>
            @include('includes.messages', ['field' => 'scale', 'min' => 0, 'max' => 30])
          </md-input-container>
        </div>
        <md-input-container class="md-block" ng-if="ifTypeIsString()">
          <label>Longitud</label>
          <input name="length" type="number" min="1" max="255" ng-model="model.length" server-validation/>
          @include('includes.messages', ['field' => 'length', 'min' => 1, 'max' => 255])
        </md-input-container>
        <md-input-container class="md-block" ng-if="ifTypeIsEnum()">
          <label>Opciones</label>
          <md-chips name="options" ng-model="model.options" md-enable-chip-edit="true" md-add-on-blur="true" class="one-line" server-validation></md-chips>
          @include('includes.messages', ['field' => 'options'])
        </md-input-container>
        <md-input-container class="md-block" ng-if="ifTypeIsDefault()">
          <label>Valor por defecto</label>
          <input name="default" type="text" ng-model="model.default" server-validation/>
          @include('includes.messages', ['field' => 'default'])
        </md-input-container>
      </div>

      <md-subheader class="md-no-sticky">Adicionales</md-subheader>
      <div layout="column" class="md-padding">
        <div layout="column" layout-gt-xs="row">
          <md-checkbox ng-model="model.nullable" ng-true-value="1" ng-false-value="0" flex-gt-xs>Nulo</md-checkbox>
          <md-checkbox ng-model="model.unsigned" ng-true-value="1" ng-false-value="0" flex-gt-xs>Positivo</md-checkbox>
          <md-checkbox ng-model="model.autoincrement" ng-true-value="1" ng-false-value="0" flex-gt-xs>Autoincremento</md-checkbox>
        </div>
        <md-input-container class="md-block" flex ng-if="!model.id">
          <label>Posición</label>
          <md-select name="position" ng-model="model.position" server-validation>
            <md-option></md-option>
            <md-option value="first">Al comienzo de la tabla</md-option>
            <md-option ng-repeat="column in columns" ng-value="column.id">Despues de
              <em>@{{ column.name }}</em>
            </md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'position'])
        </md-input-container>
      </div>

    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>