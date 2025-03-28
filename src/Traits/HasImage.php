<?php

namespace PittacusW\DatabaseManager\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait HasImage {

  public function uploadImage($file) {
    if (is_null($file) || !$file->isValid()) {
      return;
    }
    $storage = Storage::disk('public');
    $path    = business()->getKey() . "/{$this->imgPath}/{$this->getKey()}.png";
    $encode  = (string) Image::make(File::get($file->getRealPath()))
                             ->encode('png', 100);
    $storage->put($path, $encode);
  }

  public function deleteImage() {
    $storage = Storage::disk('public');
    $path    = business()->getKey() . "/{$this->imgPath}/{$this->getKey()}.png";
    $storage->delete($path);
  }

  public function getImagenAttribute() {
    $storage = Storage::disk('public');
    $path    = "{$this->imgPath}/{$this->getKey()}.png";
    if (!$storage->exists($path)) {
      return NULL;
    }

    return $storage->url($path) . "?_dc=" . $storage->lastModified($path);
  }
}