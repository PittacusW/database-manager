<md-dialog flex-xs="90" flex-gt-xs="75" flex-gt-sm="60" flex-gt-md="45">
  <md-progress-linear md-mode="indeterminate" ng-show="vm.isLoading" flex></md-progress-linear>
  <md-dialog-content class="md-dialog-content">
    <h2 class="md-title">Confirmación</h2>
    <p>¿Está seguro que desea eliminar @yield('reference')?</p>
    <div ng-if="vm.errors">
      <p md-colors="{'color': 'warn'}" class="md-body-2" ng-repeat="error in vm.errors">
        <md-icon md-colors="{'color': 'warn'}">error</md-icon>
        @{{ error[0] }}
      </p>
    </div>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised" ng-click="vm.cancel()">Cancelar</md-button>
    <md-button class="md-raised md-warn" ng-click="vm.delete()">Eliminar</md-button>
  </md-dialog-actions>
</md-dialog>