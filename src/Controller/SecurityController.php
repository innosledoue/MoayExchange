<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //if ($this->getUser()) {
         //return $this->redirectToRoute('deconnexion');
         //}

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername,
         'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'deconnexion')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
    #[Route(path:'/oubli-pass', name:'mot_pass_oublie')]
    public function forgottenPassword(Request $request,
    UserRepository $userRepository, TokenGeneratorInterface $tokenGenerator,
    EntityManagerInterface $em, SendMailService $mail): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //recherche du mail saisie par l'utisateur dans la BD  
            $user = $userRepository->findOneByEmail($form->get('email')->getData()) ;      
            
            // Vérification de l'existence d'un user
            if($user){
                //on génère un token de réinitialisation 
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

                //On génère un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token],
                UrlGeneratorInterface::ABSOLUTE_URL); 

                // On crée les données du mail
                $context = compact('url','user');

                // Envoi du mail
                $mail->send(
                    'no-reply@moayexchange.ci',
                    $user->getEmail(),
                    'Réinitialisation de mot de passe',
                    'password_reset',
                    $context
                );
                $this->addFlash('succes','Mail envoyé avec succès !');
                return $this->redirectToRoute('connexion');
            }
            //$user est null
            $this->addFlash('danger','Cet E-mail n\'existe pas, veuillez vous réinscrire.');
            return $this->redirectToRoute('inscription') ;
        }

        return $this->render('security/reset_password_request.html.twig',[
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path:'/oubli-pass/{token}', name:'reset_pass')]
    public function resetPass(
        string $token, Request $request, UserRepository $userRepository,
        EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher
    ): Response
    {
        // On vérifie si on a ce token dans la BD
        $user = $userRepository->findOneByResetToken($token);

        if($user){
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                //On efface le token
                $user->setResetToken('');
                $user->setPassword(
                    $userPasswordHasher->hashPassword($user,
                    $form->get('password')->getData())
                );
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('connexion');
            }
            return $this->render('security/reset_password.html.twig',[
                'PassForm' => $form->createView() 
            ]);
        }
        $this->addFlash('danger', 'Jeton invalide, veuillez réssaisir votre email');
        return $this->redirectToRoute('mot_pass_oublie');
    }
}
