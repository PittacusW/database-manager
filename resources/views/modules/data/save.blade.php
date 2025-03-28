<md-dialog flex="90" style="max-width: 300px;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>@{{ action === 'create' ? 'Crear' : 'Editar' }} Registro</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form" ng-submit="save()">
      <md-input-container class="md-block" ng-repeat="column in columns | filter: {type: '!tools'}" ng-if="!column.primary || action === 'update'">
        <label>@{{ column.name }}</label>
        <input name="@{{ column.name }}" type="text" ng-model="model[column.name]" ng-required="!column.nullable" ng-readonly="column.primary && action === 'update'" server-validation/>
      </md-input-container>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>