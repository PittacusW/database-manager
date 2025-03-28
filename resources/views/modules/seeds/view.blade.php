<md-card layout="column" ng-init="getData()" flex>
  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" ui-sref="home.seeds">
        <md-tooltip md-direction="top">Atras</md-tooltip>
        <md-icon>chevron_left</md-icon>
      </md-button>
      <span>Ver "@{{ seed }}"</span>
    </div>
  </md-toolbar>

  <md-card-content flex>
    <div layout-fill ui-ace="editorCfg" ng-model="data" readonly></div>
  </md-card-content>
</md-card>