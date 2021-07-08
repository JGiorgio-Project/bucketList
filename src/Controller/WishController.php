<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\services\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, Censurator $censurator): Response
    {

        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);
        if ($this->getUser()){
            $wish->setAuthor($this->getUser()->getPseudo());
        }
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);



        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            $censureText = $censurator->purify($wish->getDescription());
            $wish->setDescription($censureText);
            $entityManager->persist($wish);
            $entityManager->flush();



            $this->addFlash("success", "Idée enregistrée");
            return $this->redirectToRoute('wish_details', ['id'=>$wish->getId()]);
        }

        return $this->render('wish/create.html.twig', [
            "wishForm" => $wishForm->createView()
        ]);
    }
}
