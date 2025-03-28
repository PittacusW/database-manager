<md-card flex>
  <md-progress-linear md-mode="indeterminate" ng-show="isLoading"></md-progress-linear>

  <md-content class="md-padding" flex>
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
      <div layout="column" layout-gt-sm="row">
        <div flex>
          <md-subheader class="md-primary md-no-sticky text-uppercase">
            <md-icon>account_circle</md-icon>
            Detalles
          </md-subheader>
          <div class="md-padding">
            <md-input-container class="md-block">
              <label>Nombre</label>
              <input type="text" name="nombre" ng-model="model.nombre" required server-validation/>
              @include('includes.messages', ['field' => 'nombre'])
            </md-input-container>
            <md-input-container class="md-block">
              <label>Correo</label>
              <input type="email" name="correo" ng-model="model.correo" readonly/>
            </md-input-container>
            <md-input-container class="md-block">
              <label>RUT</label>
              <input type="text" name="rut" ng-model="model.rut" ng-rut readonly/>
            </md-input-container>
          </div>
        </div>
        <div flex>
          <md-subheader class="md-primary md-no-sticky text-uppercase">
            <md-icon>verified_user</md-icon>
            Contraseña
          </md-subheader>
          <div class="md-padding">
            <md-input-container class="md-block">
              <label>Contraseña Actual</label>
              <input type="password" name="password_current" ng-model="model.password_current" server-validation/>
              @include('includes.messages', ['field' => 'password_current'])
            </md-input-container>
            <md-input-container class="md-block">
              <label>Nueva Contraseña</label>
              <input type="password" name="password" ng-model="model.password" ng-disabled="!model.password_current" ng-required="model.password_current" server-validation/>
              @include('includes.messages', ['field' => 'password'])
            </md-input-container>
            <md-input-container class="md-block">
              <label>Confirmar Contraseña</label>
              <input type="password" name="password_confirmation" ng-model="model.password_confirmation" ng-disabled="!model.password_current || !model.password" ng-required="model.password_current && model.password"/>
              @include('includes.messages', ['field' => 'password_confirmation'])
            </md-input-container>
          </div>
        </div>
        <div flex>
          <md-subheader class="md-primary md-no-sticky text-uppercase">
            <md-icon>chrome_reader_mode</md-icon>
            Certificado Digital
          </md-subheader>
          <div class="md-padding">
            <md-input-container class="md-block">
              <label>Contraseña</label>
              <input type="password" name="certificate_password" ng-model="model.certificate_password" server-validation/>
              @include('includes.messages', ['field' => 'certificate_password'])
            </md-input-container>
            <div layout="column" layout-align="start stretch" class="md-block app-upload-btn">
              <label for="certificate-input-file" class="md-button md-raised md-accent" ng-disabled="isLoading || !model.certificate_password">
                <md-icon>insert_drive_file</md-icon>
                Seleccionar Archivo
              </label>
              <md-input-container>
                <input id="certificate-input-file" class="ng-hide" name="certificate" type="file" accept=".p12" ngf-select ngf-max-size="1MB" ng-model="certificate" ng-disabled="isLoading || !model.certificate_password" server-validation/>
                @include('includes.messages', ['field' => 'certificate'])
              </md-input-container>
            </div>
            <p class="md-caption" ng-if="model.certificated">
              <md-icon class="md-18" md-colors="::{'color': 'green'}">check_circle</md-icon>
              Certificado válido hasta el @{{model.vencimiento}}.
            </p>
            <p class="md-caption" ng-if="!model.certificated">
              <md-icon class="md-18" md-colors="::{'color': 'red'}">error</md-icon>
              El certificado no existe o es incorrecto.
            </p>
          </div>
        </div>
      </div>
    </form>
  </md-content>

  <md-card-actions layout="row" layout-align="end center">
    <md-button class="md-raised md-primary" ng-click="save()" ng-disabled="form.$invalid || isLoading">Guardar</md-button>
  </md-card-actions>
</md-card>