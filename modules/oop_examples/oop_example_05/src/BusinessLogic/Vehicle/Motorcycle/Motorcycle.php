<?php

/**
 * @file
 * Motorcycle class.
 */

namespace Drupal\oop_example_05\BusinessLogic\Vehicle\Motorcycle;

use Drupal\oop_example_05\BusinessLogic\Vehicle\Vehicle;

/**
 * Motorcycle class.
 */
class Motorcycle extends Vehicle {
  /**
   * Returns class description.
   */
  public function getDescription() {
    return t('This is a generic motorcycle.');
  }

  public function test_method_karizma(){
      return t('Karizma R is Best Bike of Hero In Current Market');
  }

}
