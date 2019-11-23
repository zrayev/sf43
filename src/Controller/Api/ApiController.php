<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    private $em;
    private $serializer;

    /**
     * PostController constructor.
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="api_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }

    /**
     * @Route("/students", name="api_students", methods={"GET"})
     */
    public function students()
    {
        $students = $this->em->getRepository(Student::class)->findAll();

        return $this->createApiResponse(['data' => $students], ['groups' => 'student:show']);
    }

    /**
     * @Route("/courses", name="api_courses", methods={"GET"})
     */
    public function courses()
    {
        $courses = $this->em->getRepository(Course::class)->findAll();

        return $this->createApiResponse(['data' => $courses], ['groups' => 'course:show']);
    }

    protected function createApiResponse($data, array $context = [], $statusCode = 200): Response
    {
        $json = $this->serialize($data, $context);

        return new Response(
            $json, $statusCode, [
                'Content-Type' => 'application/json',
            ]
        );
    }

    protected function serialize($data, $context, $format = 'json'): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}
