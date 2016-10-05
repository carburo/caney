<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 5/10/16
 * Time: 18:15
 */

namespace AppBundle\RestApi;


use FOS\RestBundle\Controller\FOSRestController;

class RestController extends FOSRestController
{
    protected function getConnection(): Connection
    {
        return $connection = $this->get("database_connection");
    }
}