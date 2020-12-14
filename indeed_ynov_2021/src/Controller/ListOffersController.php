<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Offre;
use App\Entity\Type;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListOffersController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        return $this->render('offres/index.html.twig', [
            'controller_name' => 'ListOffersController'
        ]);
    }

    /**
     * @Route("/offres", name="list_offres")
     */
    public function list(OffreRepository $repository): Response
    {

        $offres = $repository->findAll();
        return $this->render('offres/list.html.twig', [
            'offres' => $offres
        ]);
    }

    /**
     * @Route("/users/offres/create", name="create_offre")
     */ 
    public function create(EntityManagerInterface $em, Request $request)
    {
        $offre = new Offre();

        $form = $this->createFormBuilder($offre)
            ->add("title", TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("description", TextareaType::class)
            ->add("adresse")
            ->add("postcode")
            ->add("ville")

            ->add("contrat", EntityType::class, [
                "class" => Contrat::class
            ])
            ->add("type", EntityType::class, [
                "class" => Type::class
            ])
            ->add("end")
            ->add("Submit", SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ])
            ->getForm();

        $offre->setCreatedAt(new \DateTime());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute("list_offres");
        }
        
        return $this->render('offres/create.html.twig', [
            'form' => $form->createView()
        ]);        
    }
    
    /**
     * @Route("/offres/show/{id}", name="show_offre")
     */
    public function show(Offre $offre) {
        return $this->render('offres/offre.html.twig', [
            'offre' => $offre
        ]);
    }

    /**
     * @Route("/users/offres/update/{id}", name="update_offre")
     */
    public function update(Offre $offre, Request $request, EntityManagerInterface $em) {

        $form = $this->createFormBuilder($offre)
            ->add("title", TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("description", TextareaType::class)
            ->add("adresse")
            ->add("postcode")
            ->add("ville")

            ->add("contrat", EntityType::class, [
                "class" => Contrat::class
            ])
            ->add("type", EntityType::class, [
                "class" => Type::class
            ])
            ->add("end")
            ->add("Submit", SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ])
            ->getForm();

        $offre->setUpdatedAt(new \DateTime());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute("list_offres");
        }
        
        return $this->render('offres/update.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre
        ]);   
    }

    /**
     * @Route("/users/offres/delete/{id}", name="delete_offre")
     */
    public function delete(Offre $offre, EntityManagerInterface $em) {
   
        if(!$offre) {
            throw $this->createNotFoundException("L'offre n'a pas été trouvée.");
        }

        $em->remove($offre);
        $em->flush();

        return $this->redirectToRoute('list_offres');   
    }
    
}
