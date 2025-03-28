<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;
use PittacusW\DatabaseManager\Models\General\Empresa;
use PittacusW\DatabaseManager\Events\Business as BusinessEvent;

class BusinessUpdated extends BusinessEvent {

  use SerializesModels;

  /**
   * Create a new event instance.
   *
   * @param  Business  $business
   * @param  array  $data
   */
  public function __construct(Business $business, array $data) {
    $this->setBaseAttributes($business);
    $this->setDatabaseAttributes();
    $this->setThemeAttributes(array_get($data, 'colores'));
    $this->setLogoAttributes();
    $this->setRootAttributes(array_get($data, 'root'));
    $this->setRepresentativesAttributes(array_get($data, 'representatives'));
  }

}
