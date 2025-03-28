<md-card ng-init="getData()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Usuarios</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="create()">
        <md-tooltip md-direction="top">Crear Usuario</md-tooltip>
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
          <th md-column ng-repeat="column in columns" ng-style="column.style" ng-class="column.class">@{{ column.name.toUpperCase() }}</th>
        </tr>
      </thead>
      <tbody md-body>
        <tr md-row ng-show="!users.data.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="user in users.data">
          <td md-cell nowrap>@{{ user.correo }}</td>
          <td md-cell nowrap>@{{ user.nombre }}</td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-switch ng-model="user.activo" ng-change="activate(user)" ng-true-value="1" ng-false-value="0"></md-switch>
            </div>
          </td>
          <td md-cell nowrap>
            <md-button class="md-icon-button md-accent" ng-click="edit($event, user)">
              <md-tooltip md-direction="bottom">Editar</md-tooltip>
              <md-icon>edit</md-icon>
            </md-button>
            <md-button class="md-icon-button md-warn" ng-click="delete($event, user)">
              <md-tooltip md-direction="bottom">Eliminar</md-tooltip>
              <md-icon>delete</md-icon>
            </md-button>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>

  <md-card-footer style="padding: 0;">
    <md-table-pagination md-page-select md-page="params.page" md-on-paginate="getData" md-limit-options="[10, 25, 50, 100, 250]" md-limit="params.limit" md-total="@{{ users.total }}" md-label="@{{ label }}" md-boundary-links="true"></md-table-pagination>
  </md-card-footer>
</md-card>