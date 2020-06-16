<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 18:02
 */

namespace App\Controller\Departments;


use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{division}/departments", name="departments", methods={"GET"})
     * @IsGranted("departments")
     */
    public function index(Division $division)
    {
        if (!$this->getUser()->getActive())
            return $this->redirectToRoute('first_login');

        $tree = json_encode($this->buildTree(
            $this->getDoctrine()->getRepository(Department::class)->findBy(['division' => $division], ['parent' => 'ASC']),
            $this->getUser()->getDepartment()->getDivision()
        ));

        return $this->render('departments/list.html.twig', [
            'tree' => $tree,
            'divisions' => $this->getDoctrine()->getRepository(Division::class)->findBy([], ['name' => 'ASC'])
        ]);
    }

    private function buildTree(array $data, Division $division, $parentId = null)
    {
        $branch = array();

        /**
         * @var Department $element
         */
        foreach ($data as $key => $element) {
            if (is_null($element->getParent()))
                unset($data[$key]);
            if (is_null($element->getParent()) || $element->getParent()->getId() == $parentId) {
                $treeData = [
                    'text' => $element->getName(),
                    'href' => ($this->isGranted("department_edit"))?(($element->getDivision() === $division)?$this->generateUrl('department_edit', ['division' => $element->getDivision()->getId(), 'department' => $element->getId()]):'#'):'#',
                    'nodes' => $this->buildTree($data, $division, $element->getId())
                ];

                if (empty($treeData['nodes']))
                    unset($treeData['nodes']);

                $branch[] = $treeData;
            }
        }

        return $branch;
    }
}