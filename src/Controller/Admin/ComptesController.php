<?php

namespace App\Controller\Admin;

use App\Entity\Comptes;
use App\Form\ComptesType;
use App\Repository\ComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/comptes')]
class ComptesController extends AbstractController
{
    #[Route('/', name: 'app_comptes_index', methods: ['GET'])]
    public function index(ComptesRepository $comptesRepository): Response
    {
        return $this->render('admin/comptes/index.html.twig', [
            'comptes' => $comptesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comptes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compte = new Comptes();
        $form = $this->createForm(ComptesType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($compte);
            $entityManager->flush();

            return $this->redirectToRoute('app_comptes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/comptes/new.html.twig', [
            'compte' => $compte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comptes_show', methods: ['GET'])]
    public function show(Comptes $compte): Response
    {
        return $this->render('admin/comptes/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comptes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comptes $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComptesType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comptes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/comptes/edit.html.twig', [
            'compte' => $compte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comptes_delete', methods: ['POST'])]
    public function delete(Request $request, Comptes $compte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comptes_index', [], Response::HTTP_SEE_OTHER);
    }
}
