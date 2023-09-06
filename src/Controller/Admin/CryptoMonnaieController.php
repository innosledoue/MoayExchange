<?php

namespace App\Controller\Admin;

use App\Entity\CryptoMonnaie;
use App\Form\CryptoMonnaieType;
use App\Repository\CryptoMonnaieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/crypto/monnaie')]
class CryptoMonnaieController extends AbstractController
{
    #[Route('/', name: 'app_crypto_monnaie_index', methods: ['GET'])]
    public function index(CryptoMonnaieRepository $cryptoMonnaieRepository): Response
    {
        return $this->render('admin/crypto_monnaie/index.html.twig', [
            'crypto_monnaies' => $cryptoMonnaieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_crypto_monnaie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cryptoMonnaie = new CryptoMonnaie();
        $form = $this->createForm(CryptoMonnaieType::class, $cryptoMonnaie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cryptoMonnaie);
            $entityManager->flush();

            return $this->redirectToRoute('app_crypto_monnaie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/crypto_monnaie/new.html.twig', [
            'crypto_monnaie' => $cryptoMonnaie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crypto_monnaie_show', methods: ['GET'])]
    public function show(CryptoMonnaie $cryptoMonnaie): Response
    {
        return $this->render('admin/crypto_monnaie/show.html.twig', [
            'crypto_monnaie' => $cryptoMonnaie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crypto_monnaie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CryptoMonnaie $cryptoMonnaie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CryptoMonnaieType::class, $cryptoMonnaie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_crypto_monnaie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/crypto_monnaie/edit.html.twig', [
            'crypto_monnaie' => $cryptoMonnaie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crypto_monnaie_delete', methods: ['POST'])]
    public function delete(Request $request, CryptoMonnaie $cryptoMonnaie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cryptoMonnaie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cryptoMonnaie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_crypto_monnaie_index', [], Response::HTTP_SEE_OTHER);
    }
}
