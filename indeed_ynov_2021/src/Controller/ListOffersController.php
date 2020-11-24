<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/offres/create", name="create_offre")
     */ 
    public function create(Offre $offre, EntityManagerInterface $em, Request $request)
    {
        $offre = new Offre();

        $form = $this->createFormBuilder($offre)
            ->add("title")
            ->add("description", TextType::class)
            ->add("addresse")
            ->add("postcode", SmallIntType::class)
            ->add("ville")
            ->add("end", DateType::class)
            ->add("contrat", )
            ->add("type", )
            ->add("Submit", SubmitType::class)
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();

            $this->redirectToRoute("/");
        }
        
        return $this->render('offres/create.html.twig', [
            'form' => $form
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
