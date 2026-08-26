<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\ByeController.
 */
namespace Drupal\hello_world\Controller;

use Drupal\hello_world\Utility\SqlQueries;
use Civi\Api4\Activity;
use Drupal\Core\Controller\ControllerBase;

class ByeController extends ControllerBase{

  public function __construct(){
    \Drupal::service('civicrm')->initialize();
  }

  public function content() {

    $request = \Drupal::request();

    $cid = $request->query->get('cid');
    $dni = $request->query->get('dni');
    \Drupal::logger('my_module')->info('The cid is "'.$cid. '" and the dni "'.$dni.'"');

    
    $contacts = SqlQueries::getContactIfExist($cid, $dni);

    $created = false;

    if(sizeof($contacts) != 0){
      
      // TODO: Crear activitat, pero si ja se n'ha creat una en els ultims 5 minuts, no.
      $results = Activity::create(FALSE)
      ->addValue('activity_type_id', 3)
      ->addValue('source_contact_id', intval($cid))
      ->execute();

      $created = true;
    }

    

    return [
      '#theme' => 'my_template-2',
      '#created' => $created,
    ];

  }
}
