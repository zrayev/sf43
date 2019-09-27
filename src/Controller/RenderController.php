<?php

namespace App\Controller;

use Endroid\QrCode\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RenderController extends AbstractController
{
    /**
     * @Route("/render", name="render")
     */
    public function index()
    {
        $qrCode = new QrCode('Welcome to Lektorium!');
        header('Content-Type: '.$qrCode->getContentType());

        echo $qrCode->writeString(); exit;
    }
}
