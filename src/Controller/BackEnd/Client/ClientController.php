<?php

namespace App\Controller\BackEnd\Client;

use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte/client', name: 'app.compte')]
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


}
