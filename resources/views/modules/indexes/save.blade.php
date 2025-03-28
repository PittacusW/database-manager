<md-dialog flex="90" style="max-width: 600px;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>@{{ model.id ? 'Editar' : 'Crear' }} Índice</span>
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
          <md-select name="type" ng-model="model.type" server-validation>
            <md-option ng-repeat="type in types" ng-value="type.id">@{{ type.name }}</md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'type'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Columna</label>
          <md-select name="column" ng-model="model.column" required server-validation>
            <md-option ng-repeat="column in tblColumns" ng-value="column.id">@{{ column.name }}</md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'column'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Nombre</label>
          <input name="name" type="text" ng-model="model.name" required server-validation/>
          @include('includes.messages', ['field' => 'name'])
        </md-input-container>
      </div>

      <md-subheader class="md-no-sticky">
        <div layout="row" layout-align="start center">
          <span flex>Foráneo</span>
          <md-checkbox ng-model="model.foreign" style="margin-bottom: 0;"></md-checkbox>
        </div>
      </md-subheader>
      <div layout="column" class="md-padding">
        <md-input-container class="md-block">
          <label>Base de Datos</label>
          <md-select name="foreign_data.connection" ng-model="model.foreign_data.connection" ng-disabled="!model.foreign" ng-required="model.foreign" server-validation>
            @foreach($connections as $connection)
              <md-option value="{{ $connection->nombre }}">{{ $connection->nombre }}</md-option>
            @endforeach
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'foreign_data.connection'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Tabla</label>
          <md-select name="foreign_data.table" ng-model="model.foreign_data.table" ng-disabled="!model.foreign || !model.foreign_data.connection" ng-required="model.foreign" ng-change="selectForeignTable()" server-validation>
            <md-option ng-repeat="table in allTables | filter: {connection: model.foreign_data.connection}" ng-value="table.id">@{{ table.name }}</md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'foreign_data.table'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Columna</label>
          <md-select name="foreign_data.column" ng-model="model.foreign_data.column" ng-disabled="!model.foreign || !model.foreign_data.table" ng-required="model.foreign" server-validation>
            <md-option ng-repeat="column in allColumns" ng-value="column.id">@{{ column.name }}</md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'foreign_data.column'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Nombre</label>
          <input name="foreign_data.name" type="text" ng-model="model.foreign_data.name" ng-disabled="!model.foreign" ng-required="model.foreign" server-validation/>
          @include('includes.messages', ['field' => 'foreign_data.name'])
        </md-input-container>
        <div layout="row">
          <md-input-container class="md-block" flex>
            <label>Al actualizar</label>
            <md-select name="foreign_data.options.onUpdate" ng-model="model.foreign_data.options.onUpdate" ng-disabled="!model.foreign" ng-required="model.foreign" server-validation>
              <md-option ng-repeat="option in options" ng-value="option.id" ng-selected="model.foreign_data.options.onUpdate === option.id || $first">@{{ option.name }}</md-option>
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'foreign_data.options.onUpdate'])
          </md-input-container>
          <md-input-container class="md-block" flex>
            <label>Al eliminar</label>
            <md-select name="foreign_data.options.onDelete" ng-model="model.foreign_data.options.onDelete" ng-disabled="!model.foreign" ng-required="model.foreign" server-validation>
              <md-option ng-repeat="option in options" ng-value="option.id" ng-selected="model.foreign_data.options.onDelete === option.id || $first">@{{ option.name }}</md-option>
            </md-select>
            <div class="md-errors-spacer"></div>
            @include('includes.messages', ['field' => 'foreign_data.options.onDelete'])
          </md-input-container>
        </div>
      </div>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>