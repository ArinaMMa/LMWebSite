<?php

namespace App\Controller\BackEnd\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin.dashboard')]
    public function index(): Response
    {
        return $this->render('BackEnd/Admin/Dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
