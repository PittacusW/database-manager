<div layout="column" flex>
  @include('includes.loading')

  <md-toolbar layout="row" class="app-toolbar no-border">
    <div layout="row" layout-align="start center" layout-align-gt-sm="center center" ng-class="{'app-name': media('gt-sm')}">
      <md-button class="md-icon-button" ng-click="toggleSideNav()" ng-show="!media('gt-sm')">
        <md-icon>menu</md-icon>
      </md-button>
      <h5>{{ config('app.name') }}</h5>
    </div>
    <div layout="row" layout-align="end center" flex>
      <md-button class="md-icon-button" href="auth/logout">
        <md-icon>exit_to_app</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <div layout="row" flex>
    <md-sidenav class="md-sidenav-left menu-left" md-component-id="menu-left" md-is-locked-open="media('gt-sm')" ng-init="getMenu()">
      <md-content>
        <ul>
          <li ng-repeat="menu in menu">
            <a ui-sref="@{{ menu.sref }}" ui-sref-active="active" ng-click="toggleSideNav()">
              <md-icon class="md-18">@{{ menu.icon }}</md-icon>
              @{{ menu.name }}
            </a>
          </li>
        </ul>
      </md-content>
    </md-sidenav>

    <div layout="row" layout-padding ui-view flex></div>
  </div>
</div>