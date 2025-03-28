<md-card flex ng-show="ifStateIs()">

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools" ng-init="get()">
      <div flex></div>
      <md-button class="md-icon-button" ng-click="add($event)">
        <md-tooltip md-direction="top">Create table</md-tooltip>
        <md-icon>add</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="get()">
        <md-tooltip md-direction="top">Refresh</md-tooltip>
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
        <tr md-row ng-show="!tables.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="table in tables | orderBy: 'name'">
          <td md-cell nowrap>@{{ table.name }}</td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button" ui-sref="home.tables.data({table: table.name})">
                <md-tooltip md-direction="bottom">Data</md-tooltip>
                <md-icon>subject</md-icon>
              </md-button>
              <md-button class="md-icon-button" ui-sref="home.tables.indexes({table: table.name})">
                <md-tooltip md-direction="bottom">Indexes</md-tooltip>
                <md-icon>format_list_numbered</md-icon>
              </md-button>
              <md-button class="md-icon-button" ui-sref="home.tables.columns({table: table.name})">
                <md-tooltip md-direction="bottom">Columns</md-tooltip>
                <md-icon>view_column</md-icon>
              </md-button>
              <md-button class="md-icon-button md-accent" ng-click="edit($event, table)">
                <md-tooltip md-direction="bottom">Edit</md-tooltip>
                <md-icon>edit</md-icon>
              </md-button>
              <md-button class="md-icon-button md-warn" ng-click="delete($event, table)">
                <md-tooltip md-direction="bottom">Delete</md-tooltip>
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