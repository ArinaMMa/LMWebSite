<?php

namespace App\Controller\BackEnd\Admin;

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

    public function __construct (
        private EntityManagerInterface $em,
        private HorseRepository $horseRepository,
    ) {}

    #[Route('/index', name: '.show')]
    public function index(): Response
    {
        return $this->render('BackEnd/Admin/Horse/index.html.twig', [
            'controller_name' => 'HorseController',
        ]);
    }

    #[Route('/create', name: '.create')]
    public function create(): Response
    {
        return $this->render('BackEnd/Admin/Horse/create.html.twig', [
            'controller_name' => 'HorseController',
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('Backend/Admin/Horse/show.html.twig', [
            'horse' => $this->horseRepository->find($id),
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $horse = $this->horseRepository->find($id);

        $form = $this->createForm(HorseType::class, $horse);
        $form->handleRequest($request);

        if(!$horse) {
            throw $this->createNotFoundException('Cheval non trouvé');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('app.admin.horse.show', ['id' => $horse->getId()]);
        }

        return $this->render('Backend/Admin/Horse/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        $horse = $this->horseRepository->find($id);

        if(!$horse) {
            throw $this->createNotFoundException('Cheval non trouvé');
        }

        if ($this->isCsrfTokenValid('delete' . $horse->getId(), $request->request->get('_token'))) {
            $this->em->remove($horse);
            $this->em->flush();
        }

        return $this->redirectToRoute('app.admin.horse.index');
    }
}
