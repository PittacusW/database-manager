<md-card ng-init="getData()" ng-show="ifStateIs()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span flex>Errores</span>
      <md-button class="md-icon-button" ng-click="getData()">
        <md-tooltip md-direction="top">Actualizar</md-tooltip>
        <md-icon>refresh</md-icon>
      </md-button>
    </div>
  </md-toolbar>
  <md-table-container flex>
    <table md-table md-progress="promise">
      <thead md-head>
        <tr md-row>
          <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">@{{ column.name.toUpperCase() }}</th>
        </tr>
      </thead>
      <tbody md-body>
        <tr md-row ng-show="!logs.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="log in logs">
          <td md-cell nowrap>@{{ log.date | date:"dd-MM-yyyy" }}</td>
          <td md-cell nowrap class="text-center">@{{ log.all }}</td>
          <td md-cell nowrap class="text-center">@{{ log.emergency }}</td>
          <td md-cell nowrap class="text-center">@{{ log.alert }}</td>
          <td md-cell nowrap class="text-center">@{{ log.critical }}</td>
          <td md-cell nowrap class="text-center">@{{ log.error }}</td>
          <td md-cell nowrap class="text-center">@{{ log.warning }}</td>
          <td md-cell nowrap class="text-center">@{{ log.notice }}</td>
          <td md-cell nowrap class="text-center">@{{ log.info }}</td>
          <td md-cell nowrap class="text-center">@{{ log.debug }}</td>
          <td md-cell nowrap>
            <md-button class="md-icon-button" ui-sref="home.logs.view({log: log.date})">
              <md-tooltip md-direction="bottom">Ver</md-tooltip>
              <md-icon>search</md-icon>
            </md-button>
            <md-button class="md-icon-button md-warn" ng-click="delete($event, log)">
              <md-tooltip md-direction="bottom">Eliminar</md-tooltip>
              <md-icon>delete</md-icon>
            </md-button>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>
</md-card>

<div layout="row" ui-view flex ng-if="!ifStateIs()"></div>