<md-card layout="column" ng-init="getData()" flex>
  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" ui-sref="home.logs">
        <md-tooltip md-direction="top">Atras</md-tooltip>
        <md-icon>chevron_left</md-icon>
      </md-button>
      <span flex>Ver registro "@{{ log }}"</span>
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
        <tr md-row ng-show="!data.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat-start="data in data">
          <td md-cell nowrap class="text-center">
            <span class="text-bold text-uppercase md-caption" ng-style="getStyle(data.level)">@{{ data.level }}</span>
          </td>
          <td md-cell nowrap class="text-center">@{{ data.datetime }}</td>
          <td md-cell>@{{ data.header }}</td>
          <td md-cell nowrap>
            <md-button class="md-icon-button" ng-click="data.showStack = !data.showStack">
              <md-tooltip md-direction="bottom">@{{ data.showStack ? 'Ver' : 'Ocultar' }} seguimiento</md-tooltip>
              <md-icon>@{{ data.showStack ? 'expand_less' : 'expand_more' }}</md-icon>
            </md-button>
          </td>
        </tr>
        <tr md-row ng-repeat-end ng-show="data.showStack">
          <td md-cell colspan="@{{ columns.length }}" style="white-space: pre-line;">@{{ data.stack }}</td>
        </tr>
      </tbody>
    </table>
  </md-table-container>
</md-card>