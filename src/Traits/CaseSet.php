<?php

namespace PittacusW\DatabaseManager\Traits;

use Illuminate\Support\Facades\File;
use Freshwork\ChileanBundle\Laravel\Facades\Rut;
use PittacusW\DatabaseManager\Models\TransferType;
use PittacusW\DatabaseManager\Models\DocumentType;
use PittacusW\DatabaseManager\Models\Admin\Objeto;
use PittacusW\DatabaseManager\Models\ReferenceType;

trait CaseSet {

  /*------------------------------------------------------------------------------
  | Data
  '------------------------------------------------------------------------------*/
  protected function getData($content) {
    $this->put('id', $this->set->getKey());
    $this->put('nombre', $this->set->nombre);
    $this->put('details', collect());

    foreach ($this->getContent($content) as $content) {
      $id            = $this->getId($content);
      $name          = $this->getName($id);
      $document      = $this->getAttribute($content, 'DOCUMENTO');
      $documentId    = $this->getDocumentId($document);
      $reference     = $this->getAttribute($content, 'RAZON REFERENCIA');
      $referenceId   = $this->getReferenceId($reference);
      $referenceCode = $this->getReferenceCode($content);
      $transferId    = $this->getTransferId($content);
      $discount      = $this->getAttribute($content, 'DESCUENTO GLOBAL ITEMES AFECTOS');
      $items         = $this->getItems($this->set->nombre, $content, $this, $referenceCode);

      /*$subreference           = $this->getAttribute($case, 'REFERENCIA:');
      $currency                 = $this->getAttribute($case, 'MONEDA DE LA OPERACION:');
      $payment                  = $this->getAttribute($case, 'FORMA DE PAGO EXPORTACION:');
      $sale_modality            = $this->getAttribute($case, 'MODALIDAD DE VENTA:');
      $sale_clausule            = $this->getAttribute($case, 'CLAUSULA DE VENTA DE EXPORTACION:');
      $sale_clausule_total      = $this->getAttribute($case, 'TOTAL CLAUSULA DE VENTA:');
      $shipment                 = $this->getAttribute($case, 'VIA DE TRANSPORTE:');
      $shipment_port            = $this->getAttribute($case, 'PUERTO DE EMBARQUE:');
      $lading_port              = $this->getAttribute($case, 'PUERTO DE DESEMBARQUE:');
      $measurement_tara         = $this->getAttribute($case, 'UNIDAD DE MEDIDA DE TARA:');
      $measurement_gross_weigth = $this->getAttribute($case, 'UNIDAD PESO BRUTO:');
      $measurement_net_weigth   = $this->getAttribute($case, 'UNIDAD PESO NETO:');
      $package_type             = $this->getAttribute($case, 'TIPO DE BULTO:');
      $package_total            = $this->getAttribute($case, 'TOTAL BULTOS:');
      $cargo                    = $this->getAttribute($case, 'FLETE (\*\*):');
      $insurance                = $this->getAttribute($case, 'SEGURO (\*\*):');
      $country                  = $this->getAttribute($case, 'PAIS RECEPTOR Y PAIS DESTINO:');
      'subreference', 'currency', 'payment', 'sale_modality', 'sale_clausule', 'sale_clausule_total', 'shipment', 'shipment_port', 'lading_port', 'measurement_tara', 'measurement_gross_weigth', 'measurement_net_weigth', 'package_type', 'package_total', 'cargo', 'insurance', 'country'*/

      $this->get('details')
           ->push(collect(compact('id', 'name', 'documentId', 'referenceId', 'referenceCode', 'reference', 'transferId', 'discount', 'items'))->filter());
    }
  }

  protected function getContent($content) {
    preg_match_all("/(?<=^CASO )(.*?)(?=^CASO )/ms", "{$content}CASO ", $matches);

    return array_last($matches);
  }

  protected function getId(&$content) {
    $id      = strtok($content, "\n");
    $content = preg_replace('/^.+\n/', '', $content);

    return $id;
  }

  protected function getName($id) {
    return "CASO {$id}";
  }

  protected function getAttribute(&$content, $attribute) {
    $regex = "/^{$attribute}\t(.*)$/m";
    preg_match_all($regex, $content, $match);
    $content = preg_replace($regex, '', $content);

    return join(', ', array_last($match));
  }

  protected function getDocumentId($name) {
    $document = DocumentType::findByName($name)
                            ->first();

    return $document ? $document->getKey() : NULL;
  }

  protected function getReferenceId($reference) {
    $name = '-';
    if (str_is('ANULA*', $reference)) {
      $name = 'Anula';
    } elseif (str_is('DEVOLUCION DE MERCADERIA*', $reference)) {
      $name = 'Corrige monto';
    } elseif (str_is('MODIFICA MONTO*', $reference)) {
      $name = 'Corrige monto';
    } elseif (str_is('CORRIGE GIRO DEL RECEPTOR*', $reference)) {
      $name = 'Corrige texto';
    } elseif (str_is('CORRIGE GIRO*', $reference)) {
      $name = 'Corrige texto';
    }
    $reference = ReferenceType::where('glosa', 'like', "{$name}%")
                              ->first();

    return $reference ? $reference->getKey() : NULL;
  }

  protected function getReferenceCode(&$content) {
    $reference = $this->getAttribute($content, 'REFERENCIA');
    preg_match_all('/\d+-\d{1}/', $reference, $matches);

    return array_first(array_last($matches));
  }

  protected function getReferenceItems($data, $referenceCode) {
    $case = $data->get('details')
                 ->where('id', $referenceCode)
                 ->first() ?: collect();

    return $case->get('items', collect());
  }

  protected function getTransferId(&$content) {
    $transferBy = $this->getAttribute($content, 'TRASLADO POR:');
    $motive     = $this->getAttribute($content, 'MOTIVO:');
    $name       = '-';
    if ($motive === 'TRASLADO DE MATERIALES ENTRE BODEGAS DE LA EMPRESA') {
      $name = 'Traslados internos';
    } elseif ($motive === 'VENTA') {
      $name = 'Operación constituye venta';
    }

    $transfer = TransferType::where('glosa', $name)
                            ->first();

    return $transfer ? $transfer->getKey() : NULL;
  }

  /*------------------------------------------------------------------------------
  | Items
  '------------------------------------------------------------------------------*/
  protected function getItems($setName, $content, $itemsList, $referenceCode) {
    $data    = collect();
    $items   = $this->getItemsData($content);
    $headers = $this->getItemsHeader($items->shift());
    $items->each(function($item) use ($setName, $headers, $data) {
      if ($headers->count() === $item->count()) {
        $item = $headers->combine($item);
        $item->prepend(str_slug(array_first($item), '_'), 'id');
        $item->put('tributacion', stripos($setName, 'exenta') !== FALSE || stripos($item->first(), 'exento') !== FALSE ? 2 : 1);
        $data->push($item);
      }
    });

    $data = $data->when(!empty($referenceCode), function($items) use ($itemsList, $referenceCode) {
      $referencedItems = $this->getReferenceItems($itemsList, $referenceCode);
      if ($items->isEmpty()) {
        return $referencedItems;
      }

      return $items->transform(function($item) use ($itemsList, $referencedItems) {
        return $item->union($referencedItems->where('id', $item->get('id'))
                                            ->first());
      });
    });

    return $data;
  }

  protected function getItemsData($content) {
    return collect(explode("\n", $content))
     ->filter()
     ->transform(function($item) {
       return collect(explode("\t", $item));
     });
  }

  protected function getItemsHeader($content) {
    return collect($content)->transform(function($value) {
      return str_replace([
                          'precio_unitario',
                          'valor_unitario',
                          'total_linea',
                          'descuento_item',
                          'item'
                         ], [
                          'precio',
                          'precio',
                          'precio',
                          'descuento',
                          'nombre'
                         ], str_slug($value, '_'));
    });
  }

  protected function getItemsTotal($data) {
    return $data->sum(function($item) {
      $price    = (int) $item->get('precio');
      $discount = (double) (1 - (((double) $item->get('descuento')) / 100));
      $exempt   = $item->get('tributacion') === 2;
      $tax      = $exempt ? 1 : 1.19;

      return round(round($price * $discount) * $tax);
    });
  }

  protected function getItemsExempt($data) {
    return $data->sum(function($item) {
      $price    = (int) $item->get('precio');
      $discount = (double) (1 - (((double) $item->get('descuento')) / 100));
      $exempt   = $item->get('tributacion') === 2;

      return $exempt ? round($price * $discount) : 0;
    });
  }

  protected function getItemsNet($data) {
    return $data->sum(function($item) {
      $price    = (int) $item->get('precio');
      $discount = (double) (1 - (((double) $item->get('descuento')) / 100));
      $exempt   = $item->get('tributacion') === 2;

      return !$exempt ? round($price * $discount) : 0;
    });
  }

  protected function getItemsTax($data) {
    return $data->sum(function($item) {
      $price    = (int) $item->get('precio');
      $discount = (double) (1 - (((double) $item->get('descuento')) / 100));
      $exempt   = $item->get('tributacion') === 2;
      $tax      = 0.19;

      return !$exempt ? round($price * $discount * $tax) : 0;
    });
  }

  /*------------------------------------------------------------------------------
  | Save
  '------------------------------------------------------------------------------*/
  public abstract function save();

  protected function saveJson() {
    $data = $this->toJson();
    $path = str_finish($this->path, 'json/');
    $file = "{$path}{$this->set->getKey()}.json";
    File::makeDirectory($path, 0755, TRUE, TRUE);
    File::put($file, $data);

    return $file;
  }

  protected function saveXml() {
    $path = str_finish($this->path, 'xml/');
    File::makeDirectory($path, 0755, TRUE, TRUE);

    $data = [];
    $xml  = Objeto::newInstance('readXML', [
     'dbp',
     'dbg'
    ]);
    $dte  = Objeto::newInstance('Dte', [
     'dbp',
     'dbg'
    ]);

    $dte->exec('loadFirmaXML', [
     [
      'privateKey' => $this->user->pkey,
      'publicKey'  => $this->user->pubkey,
      'modulus'    => $this->user->modulus,
      'exponent'   => $this->user->exponent
     ]
    ]);
    $this->get('details')
         ->each(function($item, $key) use (&$data, $path, $dte, $xml) {
           $dte->fill([
                       'item'  => $key + 1,
                       'folio' => $item->folio,
                       'alias' => $this->business->alias
                      ]);
           $dte->exec('Crear', [
            $item->idTipoDocumento,
            $item
           ]);

           $xml->fill([
                       'newpath' => $path,
                       'file'    => $dte->get('xmlFinal'),
                       'rut'     => Rut::parse($this->business->rut)
                                       ->format(2)
                      ]);
           $xml->exec('Procesar');

           $data[] = str_replace([
                                  "]]>",
                                  "<![CDATA["
                                 ], "", $dte->get('xmlFinal'));
         });

    $send = Objeto::newInstance('EnvioDte', [
     'dbp',
     'dbg'
    ]);
    $send->fill([
                 'newpath'    => str_finish($this->path, 'xml/'),
                 'documentos' => $data,
                 'rutEnvia'   => $this->user->rut,
                 'rutRecibe'  => '60803000K'
                ]);
    $send->exec('loadFirmaXML', [
     [
      'privateKey' => $this->user->pkey,
      'publicKey'  => $this->user->pubkey,
      'modulus'    => $this->user->modulus,
      'exponent'   => $this->user->exponent
     ]
    ]);

    return $send->exec('Guardar');
  }

}
