<?php

namespace PittacusW\DatabaseManager\Traits;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Freshwork\ChileanBundle\Laravel\Facades\Rut;
use PittacusW\DatabaseManager\Models\General\Empresa;

trait Authenticate {

  protected $subdomain;
  protected $certificate;
  protected $empresa;
  protected $client;
  protected $token;
  protected $rut;
  protected $rutNb;
  protected $rutDv;
  public    $certificacion = FALSE;

  public function __construct(Empresa $empresa) {
    $this->empresa = $empresa;
    $this->rut     = Rut::parse($this->empresa->rut)
                        ->format();
    $this->rutNb   = Rut::parse($this->empresa->rut)
                        ->number();
    $this->rutDv   = Rut::parse($this->empresa->rut)
                        ->vn();
  }

  protected function subdomain() {
    if ($this->certificacion) {
      $this->subdomain = 'maullin';
    } else {
      $this->subdomain = 'palena';
    }
  }

  protected function authenticateWithCertificate() {
    $this->subdomain();
    $this->certificate = software_path($this->empresa->alias, 'documentos/Certificado/certificado.pem');
    abort_if(empty($this->certificate), 500, 'Certificado digital no instalado');
    $this->client = (new GoutteClient)->setClient((new GuzzleClient([
                                                                     'timeout' => 30,
                                                                     'verify'  => FALSE,
                                                                     'cert'    => $this->certificate
                                                                    ])));
    $this->client->request('GET', "https://{$this->subdomain}.sii.cl/cvc_cgi/dte/of_solicita_folios");
    $tokenCookie = $this->client->getCookieJar()
                                ->get('TOKEN');
    abort_if(!$tokenCookie, 500, 'No se ha podido iniciar sesión');
    $this->token = $tokenCookie->getValue();
  }

  protected function authenticateWithPassword() {
    $this->subdomain();
    $this->client = (new GoutteClient)->setClient((new GuzzleClient([
                                                                     'timeout' => 30,
                                                                     'verify'  => FALSE
                                                                    ])));
    $this->client->request('POST', 'https://zeusr.sii.cl/cgi_AUT2000/CAutInicio.cgi', [
     'rutcntr'    => $this->rut,
     'rut'        => $this->rutNb,
     'dv'         => $this->rutDv,
     'clave'      => $this->empresa->siiPassword,
     'referencia' => 'https://www4.sii.cl/consdcvinternetui/'
    ]);
    $tokenCookie = $this->client->getCookieJar()
                                ->get('TOKEN');
    abort_if(!$tokenCookie, 500, 'No se ha podido iniciar sesión');
    $this->token = $tokenCookie->getValue();
  }
}