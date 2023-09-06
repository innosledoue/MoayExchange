<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil()
    {
        $user = $this->getUser();

        return $this->render('Profile/index.html.twig', [
            'controller_name' => 'ProfileController', 'name'=>$user->getUsername()
        ]) ;
    }
}