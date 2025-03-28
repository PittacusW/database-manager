<?php

namespace PittacusW\DatabaseManager\Traits;

use Spatie\ArrayToXml\ArrayToXml;
use PittacusW\DatabaseManager\Models\Particular\Certificado;

trait Signature {

  public    $toSign;
  public    $ns = FALSE;
  public    $documentID;
  protected $signed;
  protected $certificate;
  protected $certificado;

  public function sign($file, $key) {
    $timbre = NULL;
    openssl_sign($file, $timbre, $key);
    abort_if(empty($timbre), 422, 'No se ha podido firmar electrónicamente');

    return base64_encode($timbre);
  }

  public function firmaElectronica() {
    $signedinfo     = $this->signedInfo();
    $signatureValue = ArrayToXml::convert($signedinfo);
    $signatureValue = $this->PrepareToSign($signatureValue);
    openssl_sign($signatureValue, $this->signed, $this->certificado->pkey);
    abort_if(empty($this->signed), 422, 'No se ha podido firmar electrónicamente');
    $fixedCert         = str_replace([
                                      '-----BEGIN CERTIFICATE-----',
                                      '-----END CERTIFICATE-----'
                                     ], '', $this->certificado->pubkey);
    $fixedCert         = $this->PrepareToSign($fixedCert);
    $this->certificate = wordwrap($fixedCert, 64, "\n", TRUE);
    $signature         = $this->signature($signedinfo);
    $signature         = ArrayToXml::convert($signature);

    return str_replace([
                        '><',
                        "<?xml version=\"1.0\"?>\n",
                        "<root>\n",
                        "</root>\n"
                       ], [
                        ">\n<",
                        '',
                        '',
                        ''
                       ], $signature);
  }

  protected function signedInfo() {
    if ($this->ns) {
      $xsi = [
       'xmlns'     => 'http://www.w3.org/2000/09/xmldsig#',
       'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance'
      ];
    } else {
      $xsi = [
       'xmlns' => 'http://www.w3.org/2000/09/xmldsig#'
      ];
    }
    $return = [
     '_attributes'            => $xsi,
     'CanonicalizationMethod' => [
      '_attributes' => [
       'Algorithm' => 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315'
      ],
     ],
     'SignatureMethod'        => [
      '_attributes' => [
       'Algorithm' => 'http://www.w3.org/2000/09/xmldsig#rsa-sha1'
      ]
     ],
     'Reference'              => [
      '_attributes'  => [
       'URI' => '#' . $this->documentID
      ],
      'Transforms'   => [
       'Transform' => [
        '_attributes' => [
         'Algorithm' => 'http://www.w3.org/2000/09/xmldsig#enveloped-signature'
        ],
       ],
      ],
      'DigestMethod' => [
       '_attributes' => [
        'Algorithm' => 'http://www.w3.org/2000/09/xmldsig#sha1'
       ],
      ],
      'DigestValue'  => $this->digest(),
     ]
    ];

    return $return;
  }

  protected function digest() {
    $data = $this->toSign;
    $data = str_replace(']]>', '', $data);
    $data = str_replace('<![CDATA[', '', $data);
    if ($this->documentID == 'SetDoc') {
      $data = str_replace('<SetDTE ', '<SetDTE xmlns="http://www.sii.cl/SiiDte" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ', $data);
      $data = str_replace('<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">', '<SignedInfo>', $data);
    } elseif ($this->ns) {
      $pos = strpos($data, ' ID="');
      if ($pos != "") {
        $data = substr_replace($data, ' xmlns="http://www.sii.cl/SiiDte" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ID="', $pos, strlen(' ID="'));
      }
    }

    return wordwrap(base64_encode(sha1($data, TRUE)), 64, "\n", TRUE);
  }

  protected function PrepareToSign($data) {
    $return = preg_replace('/\s\s+/', '', $data);
    $return = preg_replace("#\r|\n#", '', $return);

    return $return;
  }

  protected function signature($signedinfo) {
    return [
     'Signature' => [
      '_attributes'    => [
       'xmlns' => 'http://www.w3.org/2000/09/xmldsig#'
      ],
      'SignedInfo'     => $signedinfo,
      'SignatureValue' => wordwrap(base64_encode($this->signed), 64, "\n", TRUE),
      'KeyInfo'        => [
       'KeyValue' => [
        'RSAKeyValue' => [
         'Modulus'  => wordwrap($this->certificado->modulus, 64, "\n", TRUE),
         'Exponent' => wordwrap($this->certificado->exponent, 64, "\n", TRUE),
        ]
       ],
       'X509Data' => [
        'X509Certificate' => $this->certificate
       ]
      ]
     ]
    ];
  }

  protected function init(Certificado $certificado) {
    $this->certificado = $certificado;
  }

  protected function Sanitize($value) {
    $value = str_replace('&', '&amp;', $value);
    $value = str_replace('<', '&lt;', $value);
    $value = str_replace('>', '&gt;', $value);
    $value = str_replace('"', '&quot;', $value);
    $value = str_replace("'", '&apos;', $value);

    return $value;
  }

  protected function encodeToIso($string) {
    return mb_detect_encoding($string, [
     'UTF-8',
     'ISO-8859-1'
    ]) != 'ISO-8859-1' ? utf8_decode($string) : $string;
  }
}