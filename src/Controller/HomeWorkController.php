<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeWorkController extends AbstractController
{
    public const DEFAULT_PAGE = 1;
    public const LIMIT_PER_PAGE = 10;

    /**
     * @Route("/homework/{page<\d+>}", name="homework")
     */
    public function index(int $page = self::DEFAULT_PAGE): Response
    {
        $showHomeworkUrl = $this->generateUrl('homework_show', [
            'id' => $page !== self::DEFAULT_PAGE ? $page * self::LIMIT_PER_PAGE + random_int(0, self::LIMIT_PER_PAGE - 1) :
            $page + random_int(0, self::LIMIT_PER_PAGE - 1),
        ]);

        return $this->render('home_work/index.html.twig', [
            'page' => $page,
            'route' => $showHomeworkUrl,
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function show($id): Response
    {
        return  $this->json(['id' => $id]);
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

    /**
     * @Route("/redirect")
     */
    public function moved(): RedirectResponse
    {
        return $this->redirect('homework', 301);
    }
}
