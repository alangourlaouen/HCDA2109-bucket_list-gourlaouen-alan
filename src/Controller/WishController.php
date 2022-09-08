<?php

namespace App\Controller;

use App\Entity\Wish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class WishController extends AbstractController
{
    #[Route('/wish-list', name: 'app_wish')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $wishList = $entityManager->getRepository(Wish::class)->findBy([], ['dateCreated' => 'DESC']);

        return $this->render('wish/list.html.twig', [
            'wishList' => $wishList,
        ]);
    }

    #[Route('/wish/detail/{id}', name: 'app_wish_detail')]
    public function detail(string $id, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $wish = $entityManager->getRepository(Wish::class)->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
}
