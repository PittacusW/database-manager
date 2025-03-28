<md-card flex ng-show="ifStateIs()">

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <div flex></div>
      <md-button class="md-icon-button" ng-click="generate()">
        <md-tooltip md-direction="top">Generar Modelos</md-tooltip>
        <md-icon>sync</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="get()">
        <md-tooltip md-direction="top">Actualizar</md-tooltip>
        <md-icon>refresh</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-table-container flex ng-init="get()">
    <table md-table md-progress="promise">
      <thead md-head>
        <tr md-row>
          <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">@{{ column.name.toUpperCase() }}</th>
        </tr>
      </thead>
      <tbody md-body>
        <tr md-row ng-show="!models.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="model in models">
          <td md-cell nowrap ng-class="{'text-bold': !model.existe}">@{{ model.nombre }}</td>
          <td md-cell nowrap class="text-center">
            <md-icon class="md-18" ng-class="{'md-warn': !model.existe, 'md-primary': model.existe}">@{{ model.existe ? 'check_circle' : 'error' }}</md-icon>
          </td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button" ui-sref="home.models.view({model: model.id})" ng-disabled="!model.existe">
                <md-tooltip md-direction="bottom">Ver</md-tooltip>
                <md-icon>search</md-icon>
              </md-button>
              <md-button class="md-icon-button md-accent" ng-click="edit($event, model)" ng-disabled="!model.existe">
                <md-tooltip md-direction="bottom">Editar</md-tooltip>
                <md-icon>edit</md-icon>
              </md-button>
              <md-button class="md-icon-button md-warn" ng-click="delete($event, model)" ng-disabled="!model.existe">
                <md-tooltip md-direction="bottom">Eliminar</md-tooltip>
                <md-icon>delete</md-icon>
              </md-button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>
</md-card>

<div layout="row" ui-view flex ng-if="!ifStateIs()"></div>