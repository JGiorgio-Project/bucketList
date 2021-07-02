<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish", name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(WishRepository $wishRepository): Response
    {

        $wishList = $wishRepository->findAll();

        return $this->render('wish/list.html.twig', [
            'wishList' => $wishList
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        return $this->render('wish/details.html.twig', [
            'wish' => $wish
        ]);
    }
}
