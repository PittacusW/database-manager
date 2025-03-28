<md-dialog flex="90" flex-gt-md="75" style="max-height: 90%;">

  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-toolbar class="md-table-toolbar md-default">
    <div class="md-toolbar-tools">
      <span>@{{ model.id ? 'Editar' : 'Crear' }} Usuario</span>
      <div flex></div>
      <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon>close</md-icon>
      </md-button>
    </div>
  </md-toolbar>

  <md-dialog-content class="md-dialog-content">
    <form name="form">
      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>photo</md-icon>
        Foto
      </md-subheader>
      <div class="md-padding" flex-gt-xs="50" flex-gt-md="30" style="padding-bottom: 20px;">
        <md-grid-list md-cols="2" md-gutter="15px" md-row-height="1:1">
          <md-grid-tile class="area-crop">
            <md-grid-tile-header class="grid-btn-upload">
              <input id="profile-input-file" class="ng-hide" name="file" type="file" accept="image/*" ngf-select ngf-max-size="2MB" ng-model="image" server-validation/>
              <label for="profile-input-file" class="md-button md-raised md-icon-button" ng-disabled="isLoading">
                <md-tooltip md-direction="bottom">Adjuntar foto</md-tooltip>
                <md-icon>add_a_photo</md-icon>
              </label>
            </md-grid-tile-header>
            <md-icon class="md-48" ng-hide="image">crop</md-icon>
            <ui-cropper class="image-crop" area-type="circle" image="image" result-image="croppedImage" result-image-quality="1" result-image-size="500" result-image-format="'image/jpeg'" ng-show="image"></ui-cropper>
          </md-grid-tile>
          <md-grid-tile class="area-thumb">
            <md-icon class="md-48" ng-hide="image || model.imagen">photo</md-icon>
            <img class="image-thumb" ng-src="@{{ model.imagen }}" ng-if="!image && model.imagen"/>
            <img class="image-thumb" ng-src="@{{ croppedImage }}" ng-if="image"/>
          </md-grid-tile>
        </md-grid-list>
        <div ng-messages="form.file.$error" role="alert">
          <span class="md-caption" md-colors="{'color': 'default-warn'}" ng-message="server">@{{ errors.file[0] }}</span>
        </div>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>account_circle</md-icon>
        Detalles
      </md-subheader>
      <div class="md-padding">
        <md-input-container class="md-block">
          <label>Nivel</label>
          <md-select name="nivel" ng-model="model.nivel" required server-validation>
            <md-option ng-repeat="level in levels" ng-value="level.id">@{{ level.name }}</md-option>
          </md-select>
          <div class="md-errors-spacer"></div>
          @include('includes.messages', ['field' => 'nivel'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Nombre</label>
          <input type="text" name="nombre" ng-model="model.nombre" required server-validation/>
          @include('includes.messages', ['field' => 'nombre'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Correo</label>
          <input type="email" name="correo" ng-model="model.correo" required server-validation/>
          @include('includes.messages', ['field' => 'correo'])
        </md-input-container>
        <md-input-container>
          <md-checkbox name="activo" ng-model="model.activo" ng-true-value="1" ng-false-value="0">Activo</md-checkbox>
        </md-input-container>
      </div>

      <md-subheader class="md-primary md-no-sticky text-uppercase">
        <md-icon>verified_user</md-icon>
        Contraseña
      </md-subheader>
      <div class="md-padding">
        <md-input-container class="md-block">
          <label>Contraseña</label>
          <input name="password" type="password" ng-model="model.password" ng-required="!model.id" server-validation/>
          @include('includes.messages', ['field' => 'password'])
        </md-input-container>
        <md-input-container class="md-block">
          <label>Confirmar Contraseña</label>
          <input name="password_confirmation" type="password" ng-model="model.password_confirmation" ng-required="!model.id"/>
        </md-input-container>
      </div>
    </form>
  </md-dialog-content>

  <md-dialog-actions>
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
    <md-button class="md-raised" ng-click="cancel()">Cancelar</md-button>
  </md-dialog-actions>

</md-dialog>