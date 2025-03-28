<?php

namespace PittacusW\DatabaseManager\Traits;

use Illuminate\Support\Facades\File;
use PittacusW\DatabaseManager\Models\DocumentType;

trait BookSet {

  /*------------------------------------------------------------------------------
  | Data
  '------------------------------------------------------------------------------*/
  protected function getData($content) {
    $this->put('id', $this->set->getKey());
    $this->put('nombre', $this->set->nombre);
    $this->put('details', $this->getDetails(collect(explode("\n", $content))->filter()));
  }

  protected abstract function getDetails();

  protected abstract function getXml();

  protected function getDocumentId($name) {
    $document = DocumentType::findByName($name)
                            ->first();

    return $document ? $document->getKey() : NULL;
  }

  protected function getDocumentCode($name) {
    $document = DocumentType::findByName($name)
                            ->first();

    return $document ? $document->codigo : NULL;
  }

  protected function getReferenceCode($observation) {
    preg_match("/\d+/", $observation, $match);

    return array_first($match);
  }

  protected function getIsExempt($name) {
    return stripos($name, 'exenta') !== FALSE;
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
    $data = $this->getXml();
    $path = str_finish($this->path, 'xml/');
    $file = "{$path}{$this->set->getKey()}.xml";
    File::makeDirectory($path, 0755, TRUE, TRUE);
    File::put($file, $data);

    return $file;
  }

}
