<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\hello_world\Controller;

use Drupal\hello_world\Utility\SqlQueries;
use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase{

  public function __construct(){
    \Drupal::service('civicrm')->initialize();
  }

  public function content() {

    $request = \Drupal::request();

    $cid = $request->query->get('cid');
    $dni = $request->query->get('dni');
    //\Drupal::logger('my_module')->info('The cid is "'.$cid. '" and the dni "'.$dni.'"');
 
    $contacts = SqlQueries::getContactIfExist($cid, $dni);

    $address = "";
    $found = false;

    if(sizeof($contacts) != 0){
      $found = true;
    }

    foreach ($contacts as $contact) {
      $address .= $contact['address_primary.street_address'];
    }

    return [
      '#theme' => 'my_template',
      '#address' => $address,
      '#found' => $found,
      '#cid' => $cid,
      '#dni' => $dni,
    ];

  }
}
