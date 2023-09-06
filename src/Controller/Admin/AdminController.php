<?php 

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/showall', name: 'showall')]
    public function showall(): Response
    {
        $users = $this->repo->findAll();
        return $this->render('admin/users.html.twig', compact('users'));
    }

    /**
     * @[Route('/admin/show/{id}', name: 'profil_user')]
     * @param User $user
     * @param Request $request
     * @return \Symfony\Compoment\HttpFoundation\Response
     */
    public function showuser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        return $this->render('admin/profil_user.html.twig', [
            'user'=> $user,
            'form' => $form->createView()
        ]);
    }
}