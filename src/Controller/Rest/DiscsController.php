<?php
/**
 * Created by PhpStorm.
 * User: jme
 * Date: 13/10/2019
 * Time: 13.54
 */

namespace App\Controller\Rest;

use App\Entity\Disc;
use App\Repository\DiscRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;

class DiscsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/discs", name="get_discs")
     */
    public function getDiscs(DiscRepository $discs)
    {
        return $this->handleView($this->view($discs->findAll())->setHeader('Access-Control-Allow-Origin', '*'));
    }

    /**
     * @Rest\Post("/discs")
     */
    public function saveDisc(Request $request, DiscRepository $discs)
    {
        $data = $request->request->all();

        $disc = new Disc(Uuid::uuid4()->toString());
        $disc->setPrice($data['price']);
        $disc->setPriceStatus($data['price_status']);
        $disc->setType($data['type']);
        $disc->setName($data['name']);
        $disc->setManufacturer($data['manufacturer']);
        $disc->setColor($data['color']);
        $disc->setMaterial($data['material']);
        $disc->setSpeed($data['speed']);
        $disc->setGlide($data['glide']);
        $disc->setStability($data['stability']);
        $disc->setFade($data['fade']);
        $disc->setAdditional($data['additional']);
        $disc->setWeight($data['weight']);
        $disc->setIsMissing((bool)$data['is_missing']);
        $disc->setMissingDescription($data['missing_description']);
        $disc->setIsSold((bool)$data['is_sold']);
        $disc->setSoldAt($data['sold_at']);
        $disc->setSoldFor($data['sold_for']);
        $disc->setIsBroken((bool)$data['is_broken']);
        $disc->setIsHoleInOne((bool)$data['is_hole_in_one']);
        $disc->setHoleInOneDate($data['hole_in_one_date']);
        $disc->setHoleInOneDescription($data['hole_in_one_description']);
        $disc->setIsCollectionItem((bool)$data['is_collection_item']);
        $disc->setIsOwnStamp((bool)$data['is_own_stamp']);
        $disc->setIsDonated((bool)$data['is_donated']);
        $disc->setDonationDescription($data['donation_description']);
        $disc->setCreatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($disc);
        $em->flush();

        return $this->handleView($this->view(['ok' => true, 'data' => $request->request->all()])->setHeader('Access-Control-Allow-Origin', '*'));
    }
}
