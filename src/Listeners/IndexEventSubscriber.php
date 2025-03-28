<?php

namespace PittacusW\DatabaseManager\Listeners;

use PittacusW\DatabaseManager\Traits\Migratable;
use PittacusW\DatabaseManager\Events\IndexDeleted;
use PittacusW\DatabaseManager\Events\IndexUpdated;
use PittacusW\DatabaseManager\Events\IndexCreated;

class IndexEventSubscriber {

  use Migratable;

  /**
   * Handle table cration events.
   *
   * @param $event
   */
  public function onCreate($event) {
    $this->makeMigration($event);
  }

  /**
   * Handle table update events.
   *
   * @param $event
   */
  public function onUpdate($event) {
    $this->makeMigration($event);
  }

  /**
   * Handle table delete events.
   *
   * @param $event
   */
  public function onDelete($event) {
    $this->makeMigration($event);
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param $events
   */
  public function subscribe($events) {
    $events->listen(IndexCreated::class, self::class . '@onCreate');
    $events->listen(IndexUpdated::class, self::class . '@onUpdate');
    $events->listen(IndexDeleted::class, self::class . '@onDelete');
  }

}
