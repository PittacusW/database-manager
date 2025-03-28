<md-card ng-init="getData()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" ui-sref="home.tables">
        <md-tooltip md-direction="top">Back</md-tooltip>
        <md-icon>chevron_left</md-icon>
      </md-button>
      <span>Data in "@{{ params.table }}"</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="add($event)">
        <md-tooltip md-direction="top">Create register</md-tooltip>
        <md-icon>add</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="getData()">
        <md-tooltip md-direction="top">Refresh</md-tooltip>
        <md-icon>refresh</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-table-container flex>
    <table md-table md-progress="promise">
      <thead md-head>
        <tr md-row>
          <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">
            @{{ column.name.toUpperCase() }}
          </th>
        </tr>
      </thead>
      <tbody md-body>
        <tr md-row ng-show="!data.data.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="data in data.data">
          <td md-cell nowrap ng-repeat="column in columns | filter: {type: '!tools'}">
            @{{ data[column.name] }}
          </td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button md-accent" ng-click="edit($event, data)">
                <md-tooltip md-direction="bottom">Editar</md-tooltip>
                <md-icon>edit</md-icon>
              </md-button>
              <md-button class="md-icon-button md-warn" ng-click="delete($event, data)">
                <md-tooltip md-direction="bottom">Eliminar</md-tooltip>
                <md-icon>delete</md-icon>
              </md-button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>

  <md-card-footer style="padding: 0;">
    <md-table-pagination md-page-select md-page="params.page" md-on-paginate="getData" md-limit-options="[10, 25, 50, 100, 250]" md-limit="params.limit" md-total="@{{ data.total }}" md-label="@{{ label }}" md-boundary-links="true"></md-table-pagination>
  </md-card-footer>
</md-card>