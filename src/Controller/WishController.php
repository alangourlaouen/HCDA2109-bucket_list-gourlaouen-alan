<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Util\CensuratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

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
    public function detail(string $id, ManagerRegistry $doctrine, CensuratorService $censurator): Response
    {

        $entityManager = $doctrine->getManager();
        $wish = $entityManager->getRepository(Wish::class)->find($id);

        $wish->setDescription($censurator->purify($wish->getDescription()));

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }

    #[Route('/wish/create', name: 'app_wish_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $wish = new Wish();

        $form = $this->createForm(WishType::class, $wish);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $wish->setIsPublished(true);

            $wish->setDateCreated(new \DateTime('now'));

            $entityManager->persist($wish);

            $entityManager->flush();

            $this->addFlash('success', 'Idée enregistrée');

            return $this->redirectToRoute('app_wish');
        }

        return $this->render('wish/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
