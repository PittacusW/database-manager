@php
  //Properties
  $uses          = $model->lista_atributos->get(1, []);
  $extends       = $model->lista_atributos->get(7);
  $isSoft        = $model->columnas->contains('name', 'deleted_at');
  $traits        = $model->lista_atributos->get(2, []);
  if($isSoft)    array_push($traits, 'SoftDeletes');
  //Attributes
  $fillable      = $model->lista_atributos->get(4, []);
  $hidden        = $model->lista_atributos->get(3, []);
  $appends       = $model->lista_atributos->get(5, []);
  //$cast         = $model->columnas->whereIn('type', ['integer', 'boolean', 'float', 'array'])->pluck('name')->all();
  $dates         = $model->columnas->whereIn('type', ['date', 'timestamp'])->pluck('name')->all();
  $with          = $model->lista_atributos->get(6, []);
  //Methods
  $functions     = $model->lista_metodos->where('tipo_id', 1)->sortBy('nombre');
  $autoRelations = $model->relacionesBelognsTo->concat($model->relacionesHasMany)->map->getMethod($model)->unique('nombre')->sortBy('nombre');
  $relations     = $model->lista_metodos->where('tipo_id', 3)->sortBy('nombre');
  $scopes        = $model->lista_metodos->where('tipo_id', 2)->sortBy('nombre');
  $mutators      = $model->lista_metodos->where('tipo_id', 5)->sortBy('nombre');
  $accessors     = $model->lista_metodos->where('tipo_id', 4)->sortBy('nombre');
@endphp

{!! '<?' !!}php

namespace App\Models\{!! $model->conexion->namespace !!};

@foreach($uses as $use)use {!! $use !!};@endforeach
@if(empty($extends))use Illuminate\Database\Eloquent\Model as Eloquent;@endif
@if($isSoft)use Illuminate\Database\Eloquent\SoftDeletes;@endif

class {!! $model->nombre !!} extends {!! $extends ?: 'Eloquent' !!} {

@if(!empty($traits))
  /*------------------------------------------------------------------------------
  | Traits
  '------------------------------------------------------------------------------*/
  use {!! join(", ", $traits) !!};
@endif

/*------------------------------------------------------------------------------| Attributes'------------------------------------------------------------------------------*/public static $snakeAttributes = FALSE;public        $timestamps      = FALSE;protected     $primaryKey      = 'id{!! studly_case($model->tabla) !!}';protected $connection = '{!! $model->conexion->nombre !!}';protected $table = '{!! $model->tabla !!}';
@if(!empty($fillable))
  protected $fillable = ['{!! join("', '", $fillable) !!}'];
@endif
@if(!empty($hidden))
  protected $hidden = ['{!! join("', '", $hidden) !!}'];
@endif
@if(!empty($appends))
  protected $appends = ['{!! join("', '", $appends) !!}'];
@endif
@if(!empty($dates))
  protected $dates = ['{!! join("', '", $dates) !!}'];
  protected $dateFormat = 'd/m/Y';
@endif
@if(!empty($with))
  protected $with = ['{!! join("', '", $with) !!}'];
@endif

@if(!$functions->isEmpty())
  /*------------------------------------------------------------------------------
  | Functions
  '------------------------------------------------------------------------------*/
  @foreach($functions as $metodo)
    {!! $metodo->acceso->nombre !!} {!! $metodo->estatico ? 'static' : '' !!} function {!! $metodo->nombre !!}({!! ($metodo->parametros ? '$' : '') . collect($metodo->parametros)->implode(', $') !!}) {
    {!! $metodo->contenido !!}
    }
  @endforeach
@endif

@if(!$autoRelations->isEmpty() || !$relations->isEmpty())
  /*------------------------------------------------------------------------------
  | Relations
  '------------------------------------------------------------------------------*/
  @foreach($autoRelations as $metodo)
    public function {!! $metodo->nombre !!}() {
    {!! $metodo->contenido !!}
    }
  @endforeach

  @foreach($relations as $metodo)
    {!! $metodo->acceso->nombre !!} function {!! $metodo->nombre !!}() {
    {!! $metodo->contenido !!}
    }
  @endforeach
@endif

@if(!$scopes->isEmpty())
  /*------------------------------------------------------------------------------
  | Scopes
  '------------------------------------------------------------------------------*/
  @foreach($scopes as $metodo)
    {!! $metodo->acceso->nombre !!} function scope{!! ucfirst($metodo->nombre) !!}(${!! collect($metodo->parametros)->prepend('query')->implode(', $') !!}) {
    {!! $metodo->contenido !!}
    }
  @endforeach
@endif

@if(!$mutators->isEmpty() || !$accessors->isEmpty())
  /*------------------------------------------------------------------------------
  | Accessors & Mutators
  '------------------------------------------------------------------------------*/
  @foreach($mutators as $metodo)
    {!! $metodo->acceso->nombre !!} function set{!! ucfirst($metodo->nombre) !!}Attribute(${!! collect($metodo->parametros)->prepend('value')->implode(', $') !!}) {
    {!! $metodo->contenido !!}
    }
  @endforeach


  @foreach($accessors as $metodo)
    {!! $metodo->acceso->nombre !!} function get{!! ucfirst($metodo->nombre) !!}Attribute(${!! collect($metodo->parametros)->prepend('value')->implode(', $') !!}) {
    {!! $metodo->contenido !!}
    }
  @endforeach
@endif

}