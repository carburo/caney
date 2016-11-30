<?php

namespace AppBundle\RestApi;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

class SearchController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
        $repo = $this->getRepository();
        $results = $repo->searchPrefetch();

        return $results;
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Hostel');
    }
}
