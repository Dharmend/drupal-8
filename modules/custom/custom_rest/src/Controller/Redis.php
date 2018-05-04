<?php

namespace Drupal\custom_rest\redis;

Class Redis {
  
  public function get_connection(){
    $redis = new Redis(); 
    $redis->connect('127.0.0.1', 6379); 
    return $redis;
  }
  
}
