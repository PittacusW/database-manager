<md-card ng-init="getData()" flex>
  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>Certificaciones</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="get()">
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
          <td md-cell>@{{ business.razon_social }}</td>
          <td md-cell nowrap class="text-center">@{{ business.alias }}</td>
          <td md-cell nowrap>
            <div layout="row" layout-align="center center">
              <md-icon>@{{ business.activo ? 'check_box' : 'check_box_outline_blank' }}</md-icon>
            </div>
          </td>
          <td md-cell class="text-center">
            <md-button class="md-icon-button" ng-click="certificate($event, business)" ng-disabled="!business.activo || !business.idCertifications.length">
              <md-tooltip md-direction="bottom">Certificar</md-tooltip>
              <md-icon>touch_app</md-icon>
            </md-button>
          </td>
        </tr>
      </tbody>
    </table>
  </md-table-container>

  <md-card-footer style="padding: 0;">
    <md-table-pagination md-page-select md-page="params.page" md-on-paginate="getData" md-limit-options="[10, 25, 50, 100, 250]" md-limit="params.limit" md-total="@{{ business.total }}" md-label="@{{ label }}" md-boundary-links="true"></md-table-pagination>
  </md-card-footer>
</md-card>