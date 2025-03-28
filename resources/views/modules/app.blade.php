<!doctype html>
<html lang="es">
  <head>
    <title>{{ config('app.name') }} | Manager</title>
    <base href="{{ route('database-manager.admin') }}/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('vendor/database-manager/database-manager.css') }}" rel="stylesheet">
    <script src="{{ url('vendor/database-manager/database-manager.js') }}"></script>
  </head>
  <body ng-app="App" ng-cloak>
    <div layout="row" layout-fill ui-view></div>
  </body>
</html>