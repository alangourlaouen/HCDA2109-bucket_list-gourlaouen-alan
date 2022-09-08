<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function home()
    {

        return $this->render('main/home.html.twig');
    }

    #[Route('/legal-stuff', name: 'app_legal_stuff')]
    public function aboutUs()
    {

        return $this->render('main/about-us.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
