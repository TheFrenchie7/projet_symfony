<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListOffersController extends AbstractController
{
    /**
     * @Route("/", name="offres")
     */
    public function index(OffreRepository $repository): Response
    {

        $offres = $repository->findAll();
        return $this->render('offres/index.html.twig', [
            'controller_name' => 'ListOffersController',
            'offres' => $offres
        ]);
    }

    /**
     * @Route("/offres/{id}", name="show_offre")
     */
    public function show(Offre $offre) {
        return $this->render('offres/offre.html.twig', [
            'offre' => $offre
        ]);
    }

}
