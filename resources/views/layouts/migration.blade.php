{!! '<?' !!}php

use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;

class {!! studly_case($event->migration) !!} extends Migration {

public function up() {
@switch($event->type)
  @case('table')
  @switch($event->action)
    @case('create')
    Schema::create('{!! $event->name !!}', function(Blueprint $table) {
    $table->increments('id');
    $table->timestamps();
    @if($event->softDelete) $table->softDeletes(); @endif
    });
    @break

    @case('update')
    Schema::rename('{!! $event->oldName !!}', '{!! $event->newName !!}');
    @break

    @case('delete')
    Schema::dropIfExists('{!! $event->name !!}');
    @break
  @endswitch
  @break

  @case('column')
  @switch($event->action)
    @case('create')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->method !!}('{!! $event->name !!}'{!! $event->params !!})->default({!! $event->default !!})->nullable({!! $event->nullable !!}){!! $event->position !!};
    });
    @break

    @case('update')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->newMethod !!}('{!! $event->oldName !!}'{!! $event->newParams !!})->default({!! $event->newDefault !!})->nullable({!! $event->newNullable !!})->change();
    });
    @if($event->oldName !== $event->newName)
      Schema::table('{!! $event->table !!}', function (Blueprint $table) {
      $table->renameColumn('{!! $event->oldName !!}', '{!! $event->newName !!}');
      });
    @endif
    @break

    @case('delete')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->dropColumn('{!! $event->name !!}');
    });
    @break
  @endswitch
  @break

  @case('index')
  @switch($event->action)
    @case('create')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->method !!}('{!! $event->column !!}', '{!! $event->name !!}');
    @if($event->foreign)
      $table->foreign('{!! $event->column !!}', '{!! $event->foreignName !!}')->on(config('database.connections.{!! $event->foreignConnection !!}.database') . '.{!! $event->foreignTable !!}')->references('{!! $event->foreignColumn !!}')->onUpdate('{!! $event->foreignOnUpdate !!}')->onDelete('{!! $event->foreignOnDelete !!}');
    @endif
    });
    @break

    @case('update')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    @if($event->oldForeign)
      $table->dropForeign('{!! $event->oldForeignName !!}');
    @endif
    $table->{!! $event->oldDropMethod !!}('{!! $event->oldName !!}');
    $table->{!! $event->newMethod !!}('{!! $event->column !!}', '{!! $event->newName !!}');
    @if($event->newForeign)
      $table->foreign('{!! $event->column !!}', '{!! $event->newForeignName !!}')->on(config('database.connections.{!! $event->newForeignConnection !!}.database') . '.{!! $event->newForeignTable !!}')->references('{!! $event->newForeignColumn !!}')->onUpdate('{!! $event->newForeignOnUpdate !!}')->onDelete('{!! $event->newForeignOnDelete !!}');
    @endif
    });
    @break

    @case('delete')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    @if($event->foreign)
      $table->dropForeign('{!! $event->foreignName !!}');
    @endif
    $table->{!! $event->dropMethod !!}('{!! $event->name !!}');
    });
    @break
  @endswitch
  @break

@endswitch
}

public function down() {
@switch($event->type)
  @case('table')
  @switch($event->action)
    @case('create')
    Schema::dropIfExists('{!! $event->name !!}');
    @break

    @case('update')
    Schema::rename('{!! $event->newName !!}', '{!! $event->oldName !!}');
    @break

    @case('delete')
    \DB::statement('{!! $event->sql !!}');
    @break
  @endswitch
  @break

  @case('column')
  @switch($event->action)
    @case('create')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->dropColumn('{!! $event->name !!}');
    });
    @break

    @case('update')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->oldMethod !!}('{!! $event->newName !!}'{!! $event->oldParams !!})->default({!! $event->oldDefault !!})->nullable({!! $event->oldNullable !!})->change();
    });
    @if($event->oldName !== $event->newName)
      Schema::table('{!! $event->table !!}', function (Blueprint $table) {
      $table->renameColumn('{!! $event->newName !!}', '{!! $event->oldName !!}');
      });
    @endif
    @break

    @case('delete')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->method !!}('{!! $event->name !!}'{!! $event->params !!})->default({!! $event->default !!})->nullable({!! $event->nullable !!}){!! $event->position !!};
    });
    @break
  @endswitch
  @break

  @case('index')
  @switch($event->action)
    @case('create')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    @if($event->foreign)
      $table->dropForeign('{!! $event->foreignName !!}');
    @endif
    $table->{!! $event->dropMethod !!}('{!! $event->name !!}');
    });
    @break

    @case('update')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    @if($event->newForeign)
      $table->dropForeign('{!! $event->newForeignName !!}');
    @endif
    $table->{!! $event->newDropMethod !!}('{!! $event->newName !!}');
    $table->{!! $event->oldMethod !!}('{!! $event->column !!}', '{!! $event->oldName !!}');
    @if($event->oldForeign)
      $table->foreign('{!! $event->oldForeignColumn !!}', '{!! $event->oldForeignName !!}')->on(config('database.connections.{!! $event->oldForeignConnection !!}.database') . '.{!! $event->oldForeignTable !!}')->references('{!! $event->oldForeignColumn !!}')->onUpdate('{!! $event->oldForeignOnUpdate !!}')->onDelete('{!! $event->oldForeignOnDelete !!}');
    @endif
    });
    @break

    @case('delete')
    Schema::table('{!! $event->table !!}', function (Blueprint $table) {
    $table->{!! $event->method !!}('{!! $event->column !!}', '{!! $event->name !!}');
    @if($event->foreign)
      $table->foreign('{!! $event->foreignColumn !!}', '{!! $event->foreignName !!}')->on(config('database.connections.{!! $event->foreignConnection !!}.database') . '.{!! $event->foreignTable !!}')->references('{!! $event->foreignColumn !!}')->onUpdate('{!! $event->foreignOnUpdate !!}')->onDelete('{!! $event->foreignOnDelete !!}');
    @endif
    });
    @break
  @endswitch
  @break

@endswitch
}}
