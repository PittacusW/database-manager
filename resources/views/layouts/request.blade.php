{!! '<?' !!}php

namespace App\Requests\{!! $namespace !!};

use App\Requests\Request;

class {{ $model }}Request extends Request {

public function rules() {$rules = ['POST' => [],'PUT'  => [],];

return key_exists($this->method(), $rules) ? $rules[$this->method()] : [];}

}
