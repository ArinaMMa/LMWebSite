<?php

namespace App\Controller\BackEnd\Admin;

use App\Repository\HorseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin')]
class DashboardController extends AbstractController
{
    public function __construct (
        private HorseRepository $horseRepository,
    ) {}

    #[Route('/dashboard', name: '.dashboard')]
    public function index(): Response
    {
        return $this->render('BackEnd/Admin/Dashboard/index.html.twig', [
            'horses' => $this->horseRepository->findAll(),
        ]);
    }
}
