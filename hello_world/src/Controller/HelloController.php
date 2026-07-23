<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\hello_world\Controller;

use Civi\Api4\Contact;

class HelloController {
  public function content() {

    \Drupal::service('civicrm')->initialize();

    $request = \Drupal::request();
    $id = $request->query->get('id');

    \Drupal::logger('my_module')->info('Something happened');
    \Drupal::logger('my_module')->info($id);

    $contacts = Contact::get(FALSE)
    ->addSelect('id', 'display_name', 'email_primary.email')
    ->addWhere('id', '=', intval($id))
    ->execute();

    $stringToShow = "";

    // Nomes crear l'activitat si el dni es el correcte.
    // Posar un alert de comfirmació
    // I un altre controller que digui, la teva direcció és aquesta. Si no es correcte, contacta amb info@fespinal.com

    foreach ($contacts as $contact) {
      $stringToShow .= $contact['display_name'];
    }

    return array(
      '#type' => 'markup',
      '#markup' => $stringToShow,
    );
  }
}
