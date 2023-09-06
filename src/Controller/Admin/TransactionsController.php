<?php

namespace App\Controller\Admin;

use App\Entity\Comptes;
use App\Entity\Transactions;
use App\Form\TransactionsType;
use App\Repository\TransactionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/transactions')]
class TransactionsController extends AbstractController
{
    #[Route('/', name: 'app_transactions_index', methods: ['GET'])]
    public function index(TransactionsRepository $transactionsRepository): Response
    {
        return $this->render('admin/transactions/index.html.twig', [
            'transactions' => $transactionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transactions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, 
    EntityManagerInterface $entityManager,
    UserRepository $userRepository): Response
    {
        $user = $this->getUser(); 
        
        if(!$user){
            $this->addFlash('danger', 'Veuillez vous connecter svp!');
            return $this->redirectToRoute('connexion');
        }
        $transaction = new Transactions();
        $transaction->setExpediteur($this->getUser('username'));
        $transaction->setTypeTransaction("Transfert");
        $form = $this->createForm(TransactionsType::class, $transaction);
        $form->handleRequest($request);
        
        //$form->set('recepteur')->setData();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $exp = $userRepository->find($form->get('expediteur')->getData());
            $recep = $userRepository->find($form->get('recepteur')->getData());

            if($form->get('montant')->getData() <= $exp->getCompte()->getSolde())
            {
                
                $recep->getCompte()->setSolde($recep->getCompte()->getSolde() + $form->get('montant')->getData());
                $exp->getCompte()->setSolde($exp->getCompte()->getSolde() - $form->get('montant')->getData());
                $this->addFlash('success', 'Transaction effectué avec succès !');
            }else {
                $this->addFlash('danger', 'Solde insuffisant pour effectuer cette transaction!');
            }
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/transactions/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transactions_show', methods: ['GET'])]
    public function show(Transactions $transaction): Response
    {
        return $this->render('admin/transactions/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transactions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transactions $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionsType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/transactions/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transactions_delete', methods: ['POST'])]
    public function delete(Request $request, Transactions $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
    }
}
