<?php
/**
 * Created by PhpStorm.
 * User: jme
 * Date: 22/11/2019
 * Time: 19.28
 */

namespace App\Controller\Rest;

use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Repository\ManufacturerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;

class SecretController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/secret", name="getSecret")
     */
    public function getSecret(TypeRepository $types)
    {
        return $this->handleView($this->view(['secret' => 'Is safe with me'])->setHeader('Access-Control-Allow-Origin', '*'));
    }
}
