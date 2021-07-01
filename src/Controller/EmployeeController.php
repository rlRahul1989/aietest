<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employee")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="employee")
     */
    public function index(): Response
    {
        $empList = $this->getDoctrine()->getRepository(Employee::class)->findAll();
        return $this->render('employee/index.html.twig', [
            'employees' => $empList,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="employee_edit")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $employee = $em->getRepository(Employee::class)->find($id);
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employee);
            $em->flush();
            return $this->redirect($this->generateUrl('employee'));
        }
        return $this->render('employee/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
