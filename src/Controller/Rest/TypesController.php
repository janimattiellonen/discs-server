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

class TypesController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/types", name="get_types")
     */
    public function getManufacturers(TypeRepository $types)
    {
        return $this->handleView($this->view($types->findAll())->setHeader('Access-Control-Allow-Origin', '*'));
    }
}
