<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\ByeController.
 */
namespace Drupal\hello_world\Controller;

use Civi\Api4\Contact;
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

    $dni_uppercase = "";
    $dni_lowercase = "";
    if($dni != NULL){
      $dni_uppercase = strtoupper($dni);
      $dni_lowercase = strtolower($dni);
    }

    $contacts = Contact::get(FALSE)
    ->addSelect('id', 'display_name', 'email_primary.email', 'address_primary.street_address')
    ->addWhere('id', '=', intval($cid))
    ->addWhere('external_identifier', 'IN', [$dni_uppercase, $dni_lowercase])
    ->execute();

    $created = false;

    if(sizeof($contacts) != 0){
      
      // Crear activitat, pero si ja se n'ha creat fa una en els ultims 5 minuts, no.
      $results = \Civi\Api4\Activity::create(FALSE)
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
