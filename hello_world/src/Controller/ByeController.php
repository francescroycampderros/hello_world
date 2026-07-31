<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\ByeController.
 */
namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class ByeController extends ControllerBase{

  public function __construct(){
    \Drupal::service('civicrm')->initialize();
  }

  public function content() {

      return array(
        '#type' => 'markup',
        '#markup' => "Not found.",
      );
  }
}
