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
    $postal_code = "";
    $city = "";
    $country = "";
    $found = false;

    foreach ($contacts as $contact) {
      $found = true;
      $address .= $contact['address.street_address'];
      $postal_code .= $contact['address.postal_code'];
      $city .= $contact['address.city'];
      $country .= $contact['country.name'];
    }

    return [
      '#theme' => 'my_template',
      '#address' => $address,
      '#city' => $city,
      '#postal_code' => $postal_code,
      '#country' => $country,
      '#found' => $found,
      '#cid' => $cid,
      '#dni' => $dni,
    ];
  }
}
