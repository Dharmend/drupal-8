<?php

namespace Drupal\Common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\redis\Client\PhpRedis;

class AtCommon extends ControllerBase {

  public function getRedis($key) {
    $key_value = 0;
    $result = array();
    $redis = PhpRedis::getClient('127.0.0.1','6379');
    if ($redis->exists($key)) {
      $key_value = $redis->get($key);
    }
    $result['key_value'] = $key_value;
    return $result;
  }
  /*
   * Use to set cache of redis
   */
  public function setredis($key, $value, $ttl = 300){
    $result = array();
    $redis = PhpRedis::getClient('127.0.0.1','6379');
    $set_flag = $redis->set($key, $value);
    $redis->expire($key, $ttl);
    $result['set_flag'] = $set_flag;
    return $result;
  }
  
  /**
  * Get the list of supplements based on magazine id
  * @param int $magazine_id
  * @return array supplement list of a
 */
  function supplement_list_by_magazine_id($magazine_id){
    $data = array('_none' => '- None -');
    $query = \Drupal::database();
    $query = $query->select('node_field_data', 'nd');
    $query->leftJoin('node__field_select_magazine','sm','sm.entity_id = nd.nid');
    $query->fields('nd', ['nid', 'title','created']);
    $query->condition('nd.status',1);
    $query->condition('sm.field_select_magazine_target_id',$magazine_id);
    $query->condition('sm.bundle','supplement');
    $query->condition('nd.type', 'supplement');
    $query->orderBy('nd.created', 'DESC');
    $result = $query->execute()->fetchAll();
    foreach($result as $record){
      $data[$record->nid] = $record->title;
    }
    return $data;
  }
  
}
