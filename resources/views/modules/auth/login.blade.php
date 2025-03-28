<div layout="row" layout-align-xs="center start" layout-align-gt-xs="center center" flex>
  <md-card style="width: 300px;">
    <md-toolbar class="app-toolbar">
      <div class="md-toolbar-tools">
        <span class="md-title">{{ config('app.name') }} | <span class="md-subhead">Administración</span></span>
      </div>
    </md-toolbar>
    <md-card-content>
      <p class="md-caption md-padding text-center">Inicia sesión con tu cuenta <a href="https://www.contal.cl/"><strong>Contal SpA</strong></a></p>
      <form name="form" ng-submit="login()">
        <md-input-container class="md-block md-icon-float">
          <label>Correo</label>
          <md-icon>email</md-icon>
          <input type="email" name="correo" ng-model="model.correo" required server-validation/>
          @include('includes.messages', ['field' => 'correo'])
        </md-input-container>
        <md-input-container class="md-block md-icon-float">
          <label>Contraseña</label>
          <md-icon>lock</md-icon>
          <input type="password" name="password" ng-model="model.password" required server-validation/>
          @include('includes.messages', ['field' => 'password'])
        </md-input-container>
        <md-input-container class="md-block">
          <md-checkbox class="md-primary" ng-model="model.remember">Recuerdame</md-checkbox>
        </md-input-container>
        <md-input-container layout="row" layout-align="center center">
          <md-button type="submit" class="md-raised md-primary" ng-click="login()" ng-disabled="form.$invalid || isLoading">
            <span ng-if="!isLoading">Entrar</span>
            <span ng-if="isLoading" layout="row" layout-align="center center">
                            <md-progress-circular md-mode="indeterminate" md-diameter="20px"></md-progress-circular>
                        </span>
          </md-button>
        </md-input-container>
      </form>
    </md-card-content>
  </md-card>
</div>