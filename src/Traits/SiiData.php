<?php

namespace PittacusW\DatabaseManager\Traits;

use Illuminate\Support\Facades\File;
use Freshwork\ChileanBundle\Laravel\Facades\Rut;

trait SiiData {

  use Authenticate;

  public function __construct(Empresa $empresa) {
    new Authenticate($empresa);
  }

  public static function datosEmpresa($rut) {
    $this->authenticateWithCertificate();
    $this->rutNb = Rut::parse($this->empresa->rut)
                      ->number();
    $this->rutDv = Rut::parse($this->empresa->rut)
                      ->vn();
    $contents    = File::get("https://maullin.sii.cl/cvc_cgi/dte/ce_consulta_muestra_e_dwnld?&NOMBRE_ARCHIVO=ce_consulta_muestra_e_dwnld_ " . Rut::parse($rut)
                                                                                                                                                 ->format() . ".csv&RUT_EMP=" . Rut::parse($rut)
                                                                                                                                                                                   ->number() . "&DV_EMP=" . Rut::parse($rut)
                                                                                                                                                                                                                ->vn());
  }

  public function obtenerNombre($rut) {
    $this->authenticateWithPassword();
    $this->client->request('POST', 'https://zeus.sii.cl/cvc_cgi/stc/getstc', 'txt_code=6868&RUT=' . Rut::parse($rut)
                                                                                                       ->number() . '&DV=' . Rut::parse($rut)
                                                                                                                                ->vn() . '&PRG=STC&OPC=NOR&txt_captcha=RmRYQkdSLmlYaUUyMDE2MTAwMzE1MDEwMi5XZWplcmI2TzNBNjg2OGphT1d5QXk0a3hVMDBpYldOSjl5WlBZUVFVSnJURzVwVTFWbGVVdHdadz09eW9STTZ3ZFYyWS4%20%3D',
                           [
                            'cache-control: no-cache',
                            'Content-type: application/x-www-form-urlencoded'
                           ]);
    $result          = $this->client->getResponse()
                                    ->getContent();
    $nombre          = explode('Nombre o Raz&oacute;n Social&nbsp;:</strong></div>', $result);
    $nombre          = explode('</div>', $nombre[1]);
    $nombre          = explode('>', $nombre[0]);
    $apellidos       = array_reverse(explode(' ', $nombre[1]));
    $apellidoMaterno = ucwords(strtolower(trim($apellidos[0])));
    $apellidoPaterno = ucwords(strtolower(trim($apellidos[1])));
    $nombre          = ucwords(strtolower(trim(str_replace([
                                                            $apellidoPaterno,
                                                            $apellidoMaterno,
                                                           ], '', $nombre[1]))));

    return json_encode([
                        'apellidoPaterno' => ucfirst($apellidoPaterno),
                        'apellidoMaterno' => ucfirst($apellidoMaterno),
                        'nombre'          => $nombre,
                       ]);
  }
}