<?php

namespace PittacusW\DatabaseManager\Listeners;

use PittacusW\DatabaseManager\Traits\Seedable;
use PittacusW\DatabaseManager\Traits\Modelable;
use PittacusW\DatabaseManager\Traits\Migratable;
use PittacusW\DatabaseManager\Events\ColumnCreated;
use PittacusW\DatabaseManager\Events\ColumnDeleted;
use PittacusW\DatabaseManager\Events\ColumnUpdated;

class ColumnEventSubscriber {

  use Migratable, Modelable, Seedable;

  /**
   * Handle table creation events.
   *
   * @param $event
   */
  public function onCreate($event) {
    $this->makeMigration($event);
    $this->updateObject($event->table);
    $this->makeSeed($event->table);
  }

  /**
   * Handle table update events.
   *
   * @param $event
   */
  public function onUpdate($event) {
    $this->makeMigration($event);
    $this->updateObject($event->table);
    $this->makeSeed($event->table);
  }

  /**
   * Handle table delete events.
   *
   * @param $event
   */
  public function onDelete($event) {
    $this->makeMigration($event->data);
    $this->updateObject($event->table);
    $this->makeSeed($event->table);
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param $events
   */
  public function subscribe($events) {
    $events->listen(ColumnCreated::class, self::class . '@onCreate');
    $events->listen(ColumnUpdated::class, self::class . '@onUpdate');
    $events->listen(ColumnDeleted::class, self::class . '@onDelete');
  }

}
