<md-card flex ng-show="ifStateIs()">

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Migraciones en:</span>
      <md-select placeholder="Base de datos" class="md-body-2" style="width: 250px; padding: 10px 0 0 15px;" ng-model="database" ng-change="get()">
        @foreach($connections as $connection)
          <md-option value="{{ $connection->id }}">{{ $connection->nombre }}</md-option>
        @endforeach
      </md-select>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="undo()" ng-disabled="!database">
        <md-tooltip md-direction="top">Deshacer último lote de migraciones</md-tooltip>
        <md-icon>undo</md-icon>
      </md-button>
      <md-button class="md-icon-button" ng-click="do()" ng-disabled="!database">
        <md-tooltip md-direction="top">Ejecutar migraciones pendientes</md-tooltip>
        <md-icon>play_arrow</md-icon>
      </md-button>
      <md-button class="md-icon-button md-warn" ng-click="drop($event)" ng-disabled="!database">
        <md-tooltip md-direction="top">Resetear base de datos</md-tooltip>
        <md-icon>clear_all</md-icon>
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
        <tr md-row ng-show="!migrations.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="migration in migrations | orderBy: 'name'">
          <td md-cell nowrap ng-class="{'text-bold': !migration.id}">@{{ migration.migration }}</td>
          <td md-cell nowrap ng-class="{'text-bold': !migration.id}" class="text-center">@{{ migration.batch }}</td>
          <td md-cell nowrap class="text-center">
            <md-icon class="md-18" ng-class="{'md-warn': !migration.id, 'md-primary': migration.id}">@{{ migration.id ? 'check_circle' : 'error' }}</md-icon>
          </td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button" ui-sref="home.migrations.view({migration: migration.migration})">
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