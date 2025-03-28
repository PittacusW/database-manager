<?php

namespace PittacusW\DatabaseManager\Events;

use Illuminate\Queue\SerializesModels;
use PittacusW\DatabaseManager\Models\General\Empresa;

class BusinessCertificate {

  use SerializesModels;

  public $business;
  public $path;
  public $user;

  /**
   * Create a new event instance.
   *
   * @param  Business  $business
   */
  public function __construct(Business $business) {
    $this->business = $business;
    $this->path     = storage_path("app/private/certifications/{$business->getKey()}/");
    $this->user     = auth()->user();
  }

}
