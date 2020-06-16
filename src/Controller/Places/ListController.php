<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-08
 * Time: 13:29
 */

namespace App\Controller\Places;


use App\Adapter\Places\ReadModel\PlaceQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param PlaceQuery $placeQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/places", name="places", methods={"GET"})
     * @IsGranted("places")
     */
    public function index(PlaceQuery $placeQuery)
    {
        return $this->render('places/list.html.twig', [
            'places' => $placeQuery->findAll()
        ]);
    }
}