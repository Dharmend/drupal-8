<?php
/**
 * Created by PhpStorm.
 * User: dharmendra
 * Date: 8/4/18
 * Time: 12:45 PM
 */

//Namespace would be only folder name till the end except filename
namespace Drupal\oop_example_05\Controller;

// Declare the class which you are going to use including filename
use Drupal\oop_example_05\BusinessLogic\Vehicle\Motorcycle\Motorcycle;


class TestController {
    public function hello(){
        $mot = new Motorcycle();
        return array(
            '#markup' => 'Thanks for help<br>'.$mot->test_method_karizma(),
        );
    }
}