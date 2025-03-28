<md-card flex ng-init="get()" ng-show="ifStateIs()">

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Semillas</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="import()" ng-disabled="!database">
        <md-tooltip md-direction="top">Ejecutar semillas</md-tooltip>
        <md-icon>play_arrow</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="export()" ng-disabled="!database">
        <md-tooltip md-direction="top">Generar semillas</md-tooltip>
        <md-icon>sync</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="get()" ng-disabled="!database">
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
        <tr md-row ng-show="!seeds.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="seed in seeds | orderBy: 'name'">
          <td md-cell nowrap>@{{ seed.name }}</td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button" ui-sref="home.seeds.view({seed: seed.name})">
                <md-tooltip md-direction="bottom">Ver</md-tooltip>
                <md-icon>search</md-icon>
              </md-button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>
</md-card>

<div layout="row" ui-view flex ng-if="!ifStateIs()"></div>