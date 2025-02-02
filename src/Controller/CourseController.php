<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="course_index", methods={"GET"})
     */
    public function index(): Response
    {
        $courses = $this->getDoctrine()
            ->getRepository(Course::class)
            ->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/new", name="course_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'courseForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="course_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $this->denyAccessUnlessGranted('edit', $course);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'courseForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="course_delete", methods={"GET"})
     */
    public function delete(Course $course): Response
    {
        $this->denyAccessUnlessGranted('delete', $course);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($course);
        $entityManager->flush();
        $this->addFlash(
            'notice', $course->getTitle() . ' deleted!'
        );

        return $this->redirectToRoute('course_index');
    }
}
