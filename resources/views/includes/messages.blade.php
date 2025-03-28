@php($minText = isset($min) ? 'a'.($min-1) : '')@php($minlengthText = isset($minlength) ? 'a'.($minlength-1) : '')@php($maxText = isset($max) ? 'a'.($max+1) : '')@php($maxlengthText = isset($maxlength) ? 'a'.($maxlength+1) : '')

<div ng-messages="{!! "vm." . ($form ?? 'form') . "[" . ($object ?? "'$field'") . "].\$error" !!}" role="alert">
  <div ng-message="required">Este campo es obligatorio</div>
  <div ng-message="min">El valor de este campo debe ser mayor {{ $minText or '' }}</div>
  <div ng-message="minlength">La longitud de este campo debe ser mayor {{ $minlengthText or '' }}</div>
  <div ng-message="max">El valor de este campo debe ser menor {{ $maxText or '' }}</div>
  <div ng-message="maxlength">La longitud de este campo debe ser menor {{ $maxlengthText or '' }}</div>
  <div ng-message="email">Este campo es inválido</div>
  <div ng-message="pattern">Este campo es inválido</div>
  <div ng-message="valid">Este campo es inválido</div>
  <div ng-message="rut">Este campo es inválido</div>

  <div ng-message="server">{!! "@{{ vm.errors[" . ($object ?? "'$field'") . "][0] }}" !!}</div>
</div>