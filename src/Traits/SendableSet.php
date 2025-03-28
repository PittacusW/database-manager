<?php

namespace PittacusW\DatabaseManager\Traits;

use Freshwork\ChileanBundle\Laravel\Facades\Rut;
use PittacusW\DatabaseManager\Models\Admin\Objeto;

trait SendableSet {

  public function send() {
    $json = $this->saveJson();
    $xml  = $this->saveXml();
    $sii  = Objeto::newInstance('Sii')
                  ->fill([
                          'certificacion' => TRUE,
                          'privateKey'    => $this->user->pkey,
                          'publicKey'     => $this->user->pubkey,
                          'modulus'       => $this->user->modulus,
                          'exponent'      => $this->user->exponent,
                          'rutEnvia'      => Rut::parse($this->user->rut)
                                                ->format(2),
                          'rutEmpresa'    => $this->business->rut,
                          'xml'           => $xml
                         ])
                  ->chain('run');

    $tries   = 0;
    $status  = 0;
    $trackId = NULL;
    while ($tries < 5) {
      $response = json_decode($sii->exec('enviar'), TRUE);
      $trackId  = array_get($response, 'TRACKID');
      $tries ++;

      if (!empty($trackId)) {
        break;
      }

      sleep(10);
    }

    $this->business->syncCertifications([$this->set->getKey() => compact('trackId', 'status')], FALSE);
  }

  /*protected function saveJson() {
      $path = str_finish($this->path, 'json/');
      File::makeDirectory($path, 0755, true, true);

      $data = $this->toJson();
      File::put("{$path}{$this->set->getKey()}.json", $data);

      return $data;
  }

  protected function saveXml() {
      $path = str_finish($this->path, 'xml/');
      File::makeDirectory($path, 0755, true, true);

      $data = [];
      $xml  = Objeto::newInstance('readXML', ['dbp', 'dbg']);

      if (!$this->isBook()) {
          $dte = Objeto::newInstance('Dte', ['dbp', 'dbg']);

          $dte->exec('loadFirmaXML', [['privateKey' => $this->user->pkey, 'publicKey' => $this->user->pubkey, 'modulus' => $this->user->modulus, 'exponent' => $this->user->exponent]]);
          $this->get('details')->each(function ($item, $key) use (&$data, $path, $dte, $xml) {
              $dte->fill(['item' => $key + 1, 'folio' => $item->folio, 'alias' => $this->business->alias]);
              $dte->exec('Crear', [$item->idTipoDocumento, $item]);

              $xml->fill(['newpath' => $path, 'file' => $dte->get('xmlFinal'), 'rut' => Rut::parse($this->business->rut)->format(2)]);
              $xml->exec('Procesar');

              $data[] = str_replace(["]]>", "<![CDATA["], "", $dte->get('xmlFinal'));
          });

          $send = Objeto::newInstance('EnvioDte', ['dbp', 'dbg']);
          $send->fill(['newpath' => str_finish($this->path, 'xml/'), 'documentos' => $data, 'rutEnvia' => $this->user->rut, 'rutRecibe' => '60803000K']);
          $send->exec('loadFirmaXML', [['privateKey' => $this->user->pkey, 'publicKey' => $this->user->pubkey, 'modulus' => $this->user->modulus, 'exponent' => $this->user->exponent]]);
          $data = $send->exec('Guardar');

      } elseif ($this->isBook()) {
          $iecv = Objeto::newInstance('IECV', ['dbp', 'dbg']);
          $iecv->fill(['certificacion' => true]);
          $iecv->exec('Crear', ['VENTA', (object) $this->all()]);

          File::put("{$path}a.xml", $iecv->get('xmlFinalArray')[0]);

          $xml->fill(['newpath' => $path, 'file' => File::get("{$path}a.xml"), 'rut' => Rut::parse($this->business->rut)->format(2)]);
          $xml->exec('Procesar');

          $data = File::get("{$path}a.xml");
      }

      return $data;
  }

  protected function isBook() {
      return in_array($this->set->getKey(), [3, 4, 9]);
  }*/

}
