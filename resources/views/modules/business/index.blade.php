<md-card ng-init="getData()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Empresas</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="create()">
        <md-tooltip md-direction="top">Crear Empresa</md-tooltip>
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
        <tr md-row ng-show="!business.data.length">
          <td md-cell colspan="@{{ columns.length }}"><p class="md-caption">No records</p></td>
        </tr>
        <tr md-row ng-repeat="business in business.data">
          <td md-cell nowrap class="text-center">@{{ business.rut | rut }}</td>
          <td md-cell>@{{ business.razonSocial }}</td>
          <td md-cell nowrap class="text-center">@{{ business.alias }}</td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-switch ng-model="business.activo" ng-change="toggleActivation(business)" ng-true-value="1" ng-false-value="0"></md-switch>
            </div>
          </td>
          <td md-cell nowrap>
            <div class="text-center">
              <md-menu>
                <md-button class="md-icon-button" ng-click="openMenu($mdMenu.open)">
                  <md-icon md-menu-origin class="material-icons">more_vert</md-icon>
                </md-button>
                <md-menu-content>
                  <md-menu-item>
                    <md-button ng-click="edit($event, business)">
                      <md-icon>edit</md-icon>
                      Editar
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="delete($event, business)">
                      <md-icon>delete</md-icon>
                      Eliminar
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="archive($event, business)">
                      <md-icon>content_copy</md-icon>
                      Gestor de archivos
                    </md-button>
                  </md-menu-item>
                  <md-menu-item>
                    <md-button ng-click="resetpassword($event, business)">
                      <md-icon>lock_open</md-icon>
                      Resetear contraseña
                    </md-button>
                  </md-menu-item>
                </md-menu-content>
              </md-menu>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>

  <md-card-footer style="padding: 0;">
    <md-table-pagination md-page-select md-page="params.page" md-on-paginate="getData" md-limit-options="[10, 25, 50, 100, 250]" md-limit="params.limit" md-total="@{{ business.total }}" md-label="@{{ label }}" md-boundary-links="true"></md-table-pagination>
  </md-card-footer>
</md-card>