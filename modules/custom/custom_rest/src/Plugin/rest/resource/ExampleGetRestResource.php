<?php

namespace Drupal\custom_rest\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;
use Drupal\redis\Client\PhpRedis;
use Drupal\common\Controller\AtCommon;
//use Drupal\views\Views;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "example_get_rest_resource",
 *   label = @Translation("Example get rest resource"),
 *   uri_paths = {
 *     "canonical" = "/example-rest1"
 *   }
 * )
 * Url : http://localhost/drupal-8/test-d8/example-rest?_format=xml
 */
class ExampleGetRestResource extends ResourceBase {
  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->currentUser = $current_user;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('example_rest1'),
      $container->get('current_user')
    );
  }
  /**
   * Responds to GET requests.
   *
   * Returns a list of bundles for specified entity.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get() {
    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
   ///$view = \Drupal::service('entity.manager')->getStorage('view')->load('top_news');
   
//   if ($view) {
//      $view =  static::executableFactory()->get($view);
//   }
      die('Thanks for helping me !');
   //$response = \Drupal::httpClient()->get('http://localhost/drupal-8/test-d8/at_service/v1/top_news', array('headers' => array('Accept' => 'application/json')));
   //$data = (string) $response->getBody();
   //print_r($data);
   exit();
   $output = $result->getBody();
   $serializer = Drupal::service('serializer');
   $entity = $serializer->deserialize($output, 'Drupal\node\Entity\Node', $format);

   //$view = views_get_view_result('top_news');
   print_r($entity);
   echo "hdfjhdsjf";
   exit();
   $instance = PhpRedis::getClient('127.0.0.1','6379');
   $redis_data = AtCommon::getRedis('at_first_service');
   if($redis_data['key_value'] != ""){
     $entities = $redis_data['key_value'];
   }else{
     $entities = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadMultiple();
     
     foreach ($entities as $entity) {
      $result[$entity->id()] = $entity->title->value;
     }
     AtCommon::setredis('at_first_service',$entities,20);
   }
   print_r($entities);
    
    $response = new ResourceResponse($result);
    $response->addCacheableDependency($result);
    return $response;
  }
}