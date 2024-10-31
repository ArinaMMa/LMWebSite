<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    //Afficher le formulaire de connexion
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authUtils): Response
    {
        //Récupérer les erreurs de connexion s'il y en a
        //Récupérer le dernier nom d'utilisateur saisi
        return $this->render('Security/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'lastUsername' => $authUtils->getLastUsername(),
        ]);
    }

    //Créer un compte
    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $client = new Client;

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Hasher le mot de passe
            $client->setPassword($passwordEncoder->hashPassword($client, $client->getPassword()));

            //Attribuer le rôle ROLE_USER
            $client->setRoles(['ROLE_USER']);

            //Enregistrer le client en BDD
            $em->persist($client);
            $em->flush();

            //Rediriger vers la page de connexion avec un message de succès
            $this->addFlash('success', 'Votre compte a bien été créé.');

            return $this->redirectToRoute('login');
        }

        return $this->render('Security/register.html.twig', [
            'form' => $form,
        ]);
    }

    //Se déconnecter
    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): void
    {
        //Cette méthode est vide, elle est juste là pour permettre à Symfony de gérer la déconnexion
    }
}
