<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\hello_world\Controller;

use Civi\Api4\Contact;
use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase{

  public function __construct(){
    \Drupal::service('civicrm')->initialize();
  }

  public function content() {

    $request = \Drupal::request();

    $id = $request->query->get('id');
    $dni = $request->query->get('dni');
    //\Drupal::logger('my_module')->info('The id is "'.$id. '" and the dni "'.$dni.'"');
    
    $dni_uppercase = "";
    $dni_lowercase = "";
    if($dni != NULL){
      $dni_uppercase = strtoupper($dni);
      $dni_lowercase = strtolower($dni);
    }

    $contacts = Contact::get(FALSE)
    ->addSelect('id', 'display_name', 'email_primary.email', 'address_primary.street_address')
    ->addWhere('id', '=', intval($id))
    ->addWhere('external_identifier', 'IN', [$dni_uppercase, $dni_lowercase])
    ->execute();




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
    ];

  }
}
