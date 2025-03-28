<?php

namespace PittacusW\DatabaseManager\Listeners;

use PittacusW\DatabaseManager\Traits\Seedable;
use PittacusW\DatabaseManager\Traits\Modelable;
use PittacusW\DatabaseManager\Traits\Migratable;
use PittacusW\DatabaseManager\Events\TableCreated;
use PittacusW\DatabaseManager\Events\TableDeleted;
use PittacusW\DatabaseManager\Events\TableUpdated;

class TableEventSubscriber {

  use Migratable, Modelable, Seedable;

  /**
   * Handle table cration events.
   *
   * @param $event
   */
  public function onCreate($event) {
    $this->makeMigration($event);
    $this->makeObject($event->name);
  }

  /**
   * Handle table update events.
   *
   * @param $event
   */
  public function onUpdate($event) {
    $this->makeMigration($event);
    $this->updateObject($event->oldName, $event->newName);
    $this->makeSeed();
  }

  /**
   * Handle table delete events.
   *
   * @param $event
   */
  public function onDelete($event) {
    $this->makeMigration($event);
    $this->deleteObject($event->name);
    $this->makeSeed();
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param $events
   */
  public function subscribe($events) {
    $events->listen(TableCreated::class, self::class . '@onCreate');
    $events->listen(TableUpdated::class, self::class . '@onUpdate');
    $events->listen(TableDeleted::class, self::class . '@onDelete');
  }
}
