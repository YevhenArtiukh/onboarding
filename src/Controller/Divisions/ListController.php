<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 17:32
 */

namespace App\Controller\Divisions;


use App\Adapter\Divisions\ReadModel\DivisionQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param DivisionQuery $divisionQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/divisions", name="divisions", methods={"GET"})
     * @IsGranted("divisions")
     */
    public function index(DivisionQuery $divisionQuery)
    {
        return $this->render('divisions/list.html.twig', [
            'divisions' => $divisionQuery->findAll()
        ]);
    }
}