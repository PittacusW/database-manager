<md-card ng-init="getData()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <md-button class="md-icon-button" ui-sref="home.tables">
        <md-tooltip md-direction="top">Atras</md-tooltip>
        <md-icon>chevron_left</md-icon>
      </md-button>
      <span>Índices en "@{{ params.table }}"</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="add($event)">
        <md-tooltip md-direction="top">Crear índice</md-tooltip>
        <md-icon>add</md-icon>
      </md-button>
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
          <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">
                        <span>
                            <md-tooltip md-direction="top" ng-if="column.tooltip">@{{ column.tooltip }}</md-tooltip>
                            @{{ column.name.toUpperCase() }}
                        </span>
          </th>
        </tr>
      </thead>
      <tbody md-body>
        <tr md-row ng-show="!indexes.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="index in indexes">
          <td md-cell nowrap>@{{ getType(index.type).name }}</td>
          <td md-cell nowrap>@{{ index.name }}</td>
          <td md-cell nowrap>@{{ index.column }}</td>
          <td md-cell nowrap class="text-center">
            <md-icon class="md-18">@{{ index.foreign ? 'check_box' : 'check_box_outline_blank' }}</md-icon>
          </td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-button class="md-icon-button md-accent" ng-click="edit($event, index)">
                <md-tooltip md-direction="bottom">Editar</md-tooltip>
                <md-icon>edit</md-icon>
              </md-button>
              <md-button class="md-icon-button md-warn" ng-click="delete($event, index)">
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