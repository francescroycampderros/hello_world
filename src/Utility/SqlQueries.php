<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\ByeController.
 */
namespace Drupal\hello_world\Utility;

use Civi\Api4\Contact;

final class SqlQueries
{
    private function __construct()
    {
        // Prevent instantiation
    }

    public static function getContactIfExist($cid, $dni)
    {
        $dni_uppercase = "";
        $dni_lowercase = "";
        if($dni != NULL){
            $dni_uppercase = strtoupper($dni);
            $dni_lowercase = strtolower($dni);
        }

        $contacts = Contact::get(FALSE)
        ->addSelect('*', 'address.*', 'country.*')
        ->addJoin('Address AS address', 'LEFT')
        ->addJoin('Country AS country', 'LEFT')
        ->addWhere('id', '=', intval($cid))
        ->addWhere('external_identifier', 'IN', [$dni_uppercase, $dni_lowercase])
        ->execute();

        return $contacts;
    }
}