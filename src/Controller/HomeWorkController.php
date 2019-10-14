<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeWorkController extends AbstractController
{
    /**
     * @Route("/homework/{page<\d+>}", name="home_work")
     *
     * @param $page
     * @return Response
     */
    public function index($page = 1): Response
    {
        return $this->render('home_work/index.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function show($id): Response
    {
        $response = new Response();
        $response->setContent(json_encode([
            'id' => $id,
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param $word
     *
     * @return Response
     */
    public function validation($word): Response
    {
        $response = new Response();
        $response->setContent('<p>' . $word . ' - valid word' . '<strong>' . '</strong>' . '</p>');

        return $response;
    }
}
