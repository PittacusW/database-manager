<?php

namespace PittacusW\DatabaseManager\Traits;

use phpseclib\File\X509;

trait LoadX509 {

  public static function extract($file, $password) {
    $certificate = file_get_contents($file);
    abort_if(!openssl_pkcs12_read($certificate, $info, $password), 500, 'No se ha podido abrir el certificado');
    $cert = with(new X509())->loadX509($info['cert']);
    abort_if(empty($data), 500, 'No se ha podido abrir el certificado');
    foreach ($cert['tbsCertificate']['extensions'] as $data) {
      if ('id-ce-subjectAltName' != $data['extnId']) {
        continue;
      }
      $rut = filter_rut($data['extnValue'][0]['otherName']['value']['ia5String']);
    }
    foreach ($cert['tbsCertificate']['issuer']['rdnSequence'] as $data) {
      if ($data[0]['type'] != 'id-at-commonName') {
        continue;
      }
      $emisor = $data[0]['value']['printableString'];
    }
    foreach ($cert['tbsCertificate']['subject']['rdnSequence'] as $data) {
      if ($data[0]['type'] == 'id-at-commonName') {
        $nombre = $data[0]['value'];
        if (isset($nombre['printableString'])) {
          $nombre = ucwords($nombre['printableString']);
        } elseif (isset($nombre['utf8String'])) {
          $nombre = ucwords($nombre['utf8String']);
        }
      } elseif ($data[0]['type'] == 'pkcs-9-at-emailAddress') {
        $mail = $data[0]['value']['ia5String'];
      }
    }
    $inicio       = date_format(date_create($cert['validity']['notBefore']), 'Y-m-d');
    $vencimiento  = date_format(date_create($cert['validity']['notAfter']), 'Y-m-d');
    $rsaPKDecrypt = openssl_pkey_get_details(openssl_pkey_get_private($info['pkey']));
    $modulus      = base64_encode($rsaPKDecrypt['rsa']['n']);
    $exponent     = base64_encode($rsaPKDecrypt['rsa']['e']);
    $pkey         = array_get($info, 'pkey');
    $pubkey       = array_get($info, 'cert');
    $serie        = $cert['tbsCertificate']['serialNumber']->value;

    return compact('inicio', 'vencimiento', 'modulus', 'exponent', 'pkey', 'pubkey', 'serie', 'rut', 'nombre', 'mail', 'emisor');
  }
}