<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;
use PittacusW\DatabaseManager\Models\General\Empresa;
use PittacusW\DatabaseManager\Events\Business as BusinessEvent;

class BusinessResetPassword extends BusinessEvent {

  use SerializesModels;

  /**
   * Create a new event instance.
   *
   * @param  Business  $business
   */
  public function __construct(Business $business) {
    $this->setBaseAttributes($business);
    $this->setDatabaseAttributes();
  }

}
