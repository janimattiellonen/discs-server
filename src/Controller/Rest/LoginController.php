<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class LoginController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/login", name="api_login")
     */
    public function login()
    {
        return $this->handleView($this->view(['ok' => true])->setHeaders(['Access-Control-Allow-Origin' => '*', 'Access-Control-Allow-Credentials' => true]));
    }

}
