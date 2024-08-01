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

    public function __construct (
        private EntityManagerInterface $em,
        private HorseRepository $horseRepository,
    ) {}

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('BackEnd/Admin/Horse/index.html.twig', [
            'horses' => $this->horseRepository->findAll(),
            
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $horse = new Horse();
        $form = $this->createForm(HorseType::class, $horse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($horse);
            $this->em->flush();

            return $this->redirectToRoute('admin.horse.index', ['id' => $horse->getId()]);
        }

        return $this->render('BackEnd/Admin/Horse/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.read', methods: ['GET'])]
    public function read(int $id): Response
    {
        return $this->render('Backend/Admin/Horse/read.html.twig', [
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
            $this->em->persist($horse);
            $this->em->flush();

            return $this->redirectToRoute('admin.horse.index', ['id' => $horse->getId()]);
        }

        return $this->render('Backend/Admin/Horse/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request, ?Horse $horse): Response
    {
        if(!$horse) {
            throw $this->createNotFoundException('Cheval non trouvé');
            // return $this->redirectToRoute('admin.horse.index');
        }

        if ($this->isCsrfTokenValid('delete' . $horse->getId(), $request->request->get('_token'))) {
            $this->em->remove($horse);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.horse.index');
    }
}
