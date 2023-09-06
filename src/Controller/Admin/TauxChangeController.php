<?php

namespace App\Controller\Admin;

use App\Entity\TauxChange;
use App\Form\TauxChangeType;
use App\Repository\TauxChangeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/taux/change')]
class TauxChangeController extends AbstractController
{
    #[Route('/', name: 'app_taux_change_index', methods: ['GET'])]
    public function index(TauxChangeRepository $tauxChangeRepository): Response
    {
        return $this->render('admin/taux_change/index.html.twig', [
            'taux_changes' => $tauxChangeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_taux_change_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tauxChange = new TauxChange();
        $form = $this->createForm(TauxChangeType::class, $tauxChange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tauxChange);
            $entityManager->flush();

            return $this->redirectToRoute('app_taux_change_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/taux_change/new.html.twig', [
            'taux_change' => $tauxChange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_taux_change_show', methods: ['GET'])]
    public function show(TauxChange $tauxChange): Response
    {
        return $this->render('admin/taux_change/show.html.twig', [
            'taux_change' => $tauxChange,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_taux_change_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TauxChange $tauxChange, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TauxChangeType::class, $tauxChange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_taux_change_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/taux_change/edit.html.twig', [
            'taux_change' => $tauxChange,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_taux_change_delete', methods: ['POST'])]
    public function delete(Request $request, TauxChange $tauxChange, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tauxChange->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tauxChange);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_taux_change_index', [], Response::HTTP_SEE_OTHER);
    }
}
