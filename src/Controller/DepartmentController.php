<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/department")
 */
class DepartmentController extends AbstractController
{
    /**
     * @Route("/", name="department_index", methods={"GET"})
     */
    public function index(): Response
    {
        $departments = $this->getDoctrine()
            ->getRepository(Department::class)
            ->findAll();

        return $this->render('department/index.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/new", name="department_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $department = new Department();
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/new.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="department_show", methods={"GET"})
     * @param Department $department
     *
     * @return Response
     */
    public function show(Department $department): Response
    {
        return $this->render('department/show.html.twig', [
            'department' => $department,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="department_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Department $department
     *
     * @return Response
     */
    public function edit(Request $request, Department $department): Response
    {
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/edit.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="department_delete", methods={"GET"})
     * @param Department $department
     *
     * @return Response
     */
    public function delete(Department $department): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($department);
        $entityManager->flush();

        return $this->redirectToRoute('department_index');
    }
}
