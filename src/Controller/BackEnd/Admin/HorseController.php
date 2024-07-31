<?php

namespace App\Controller\BackEnd\Admin;

use App\Entity\Horse;
use App\Form\HorseType;
use App\Repository\HorseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/horse', name: 'admin.horse')]
class HorseController extends AbstractController
{
    //préparation à l'utilisation d'EntityManagerInterface et HorseRepository
    //EntityManagerInterface permet de manipuler les entités dans la base de données (insertion, suppression, modification) 
    //HorseRepository permet de récupérer des entités de la base de données 
    public function __construct (
        private EntityManagerInterface $em,
        private HorseRepository $horseRepository,
    ) {}

    //Affichage de la page d'accueil avec la liste des chevaux
    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('BackEnd/Admin/Horse/index.html.twig', [
            'horses' => $this->horseRepository->findAll(),
            
        ]);
    }

    //Page de création d'un cheval
    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        //Création d'un nouvel objet Horse
        $horse = new Horse();
        //Création du formulaire
        $form = $this->createForm(HorseType::class, $horse);
        $form->handleRequest($request);

        //Si le formulaire est soumis et valide, on enregistre le cheval en base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($horse);
            $this->em->flush();

            return $this->redirectToRoute('admin.horse.index', ['id' => $horse->getId()]);
        }

        //Rendu de la page une fois le cheval enregistré + lien avec le formulaire
        return $this->render('BackEnd/Admin/Horse/create.html.twig', [
            'form' => $form,
        ]);
    }

    //Page de lecture d'une fiche cheval
    #[Route('/{id}', name: '.read', methods: ['GET'])]
    public function read(int $id): Response
    {
        return $this->render('Backend/Admin/Horse/read.html.twig', [
            'horse' => $this->horseRepository->find($id),
        ]);
    }

    //Page de modification d'une fiche cheval
    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        //Récupération du cheval à modifier
        $horse = $this->horseRepository->find($id);

        $form = $this->createForm(HorseType::class, $horse);
        $form->handleRequest($request);

        //Si le cheval n'existe pas, on renvoie une erreur
        if(!$horse) {
            throw $this->createNotFoundException('Cheval non trouvé');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin.horse.index', ['id' => $horse->getId()]);
        }

        return $this->render('Backend/Admin/Horse/edit.html.twig', [
            'form' => $form,
        ]);
    }

    //Suppression d'une fiche cheval
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request, ?Horse $horse): Response
    {
        if(!$horse) {
            throw $this->createNotFoundException('Cheval non trouvé');
            // return $this->redirectToRoute('admin.horse.index');
        }

        //Vérification du token CSRF et suppression du cheval
        if ($this->isCsrfTokenValid('delete' . $horse->getId(), $request->request->get('_token'))) {
            $this->em->remove($horse);
            $this->em->flush();
        }

        //Redirection vers la page d'accueil
        return $this->redirectToRoute('admin.horse.index');
    }
}
