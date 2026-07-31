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
    //Fer comprovacio perque no peti si no hi ha id i dni
    $id = $request->query->get('id');
    $dni = $request->query->get('dni');
    
    $dni_uppercase = strtoupper($dni);
    $dni_lowercase = strtolower($dni);

    //\Drupal::logger('my_module')->info('Something happened');
    //\Drupal::logger('my_module')->info($id);

    $contacts = Contact::get(FALSE)
    ->addSelect('id', 'display_name', 'email_primary.email', 'address_primary.street_address')
    ->addWhere('id', '=', intval($id))
    ->addWhere('external_identifier', 'IN', [$dni_uppercase, $dni_lowercase])
    ->execute();

    $stringToShow = "";

    // Nomes crear l'activitat si el dni es el correcte.
    // Posar un alert de comfirmació
    // I un altre controller que digui, la teva direcció és aquesta. Si no es correcte, contacta amb info@fespinal.com

    if(sizeof($contacts) == 0){
      return array(
        '#type' => 'markup',
        '#markup' => "Not found.",
      );
    }

    foreach ($contacts as $contact) {
      $stringToShow .= $contact['address_primary.street_address'];
    }

    return [
      '#theme' => 'my_template',
      '#test_var' => $stringToShow,
    ];

  }
}
