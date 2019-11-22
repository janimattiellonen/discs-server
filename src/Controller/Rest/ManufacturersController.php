<?php
/**
 * Created by PhpStorm.
 * User: jme
 * Date: 22/11/2019
 * Time: 19.28
 */

namespace App\Controller\Rest;

use App\Entity\Disc;
use App\Repository\DiscRepository;
use App\Repository\ManufacturerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;

class ManufacturersController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/manufacturers", name="get_manufacturers")
     */
    public function getManufacturers(ManufacturerRepository $manufacturers)
    {
        return $this->handleView($this->view($manufacturers->findAll())->setHeader('Access-Control-Allow-Origin', '*'));
    }
}
