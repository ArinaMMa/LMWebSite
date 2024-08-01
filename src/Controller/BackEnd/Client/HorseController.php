<?php

namespace App\Controller\BackEnd\Client;

use App\Entity\Horse;
use App\Form\HorseType;
use App\Repository\HorseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('profile/client/horses', name: 'app.client.horses')]
class HorseController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private HorseRepository $horseRepository,
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Client/Horse/index.html.twig', [
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

            return $this->redirectToRoute('app.client.horse.show', ['id' => $horse->getId()]);
        }

        return $this->render('Backend/Client/Horse/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('Backend/Client/Horse/show.html.twig', [
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

            // TODO: Add a flash message
            // TODO: Redirect to the show page
            return $this->redirectToRoute('app.client.horses.index', ['id' => $horse->getId()]);
        }

        return $this->render('Backend/Client/Horse/edit.html.twig', [
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

        return $this->redirectToRoute('app.client.horse.index');
    }
}
