<?php

namespace App\Controller\BackEnd\Client;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('profile/client', name: 'app.client')]
class ClientController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ClientRepository $clientRepository,
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Client/index.html.twig', [
            'controller_name' =>  'ClientController',
        ]);
    }

    //Afficher les informations du client
    #[Route('/show', name: '.show', methods: ['GET'])]
    public function show(): Response
    {
        $client = $this->getUser();
        return $this->render('Backend/Client/show.html.twig', [
            'client' => $client,
        ]);
    }

    //Modification des informations du client
    #[Route('/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        $client = $this->getUser();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($client);
            $this->em->flush();
            
            // $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');
            return $this->redirectToRoute('app.client.index');
        }

        return $this->render('Backend/Client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    //Suppression du compte client
    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request, int $id): RedirectResponse
    {
        $client = $this->clientRepository->find($id);
        
        if(!$client) {
            throw $this->createNotFoundException('Client non trouvé');
            // return $this->redirectToRoute('app.home');
        }

        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $this->em->remove($client);
            $this->em->flush();
        }
        
        return $this->redirectToRoute('app.home');
    }

    //TODO: renvoi vers la page profil du client après login
}
