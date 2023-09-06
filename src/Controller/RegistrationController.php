<?php

namespace App\Controller;

use App\Entity\Comptes;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAthenticatorAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
    UserAuthenticatorInterface $userAuthenticator, UserAthenticatorAuthenticator $authenticator,
    EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new User();
        $compte = new Comptes();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // Création du compte de l'utilisateur avec un solde initial 0
            $user->setCompte($compte->setSolde('0'));

            $entityManager->persist($user);
            $entityManager->flush();

            // On génère le JWT
            // On crée le header 
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //On crée le Payload
            $payload = [
                'user_id' => $user->getId()
            ];

            //On génère le token
            $token = $jwt->generate($header, $payload,
            $this->getParameter('app.jwtsecret')) ;

            // do anything else you need here, like send an email
            $mail->send(
                'no-reply@moayexchange.ci',
                $user->getEmail(),
                'Activation de votre compte sur le site MoayExchange',
                'register',
                compact('user', 'token')
        );
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt,
    UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        //On vérifie si le token est valide, n'as pas expiré et n'as pas été modifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && 
        $jwt->check($token, $this->getParameter('app.jwtsecret')))
        {//On récupère le payload
            $payload = $jwt->getPayload($token);
        //On récupère le user du token 
            $user = $userRepository->find($payload['user_id']);
        //On vérifie que l'utilisateur existe et n'as pas encore activé son compte
        if($user && !$user->isIsVerified()){
            $user->setIsVerified(true);
            $em->flush($user);
            $this->addFlash('success', 'Utilisateur activé');
        return $this->redirectToRoute('profil');
        //return $this->render('profile/index.html.twig', ['name'=>$user->getUsername()]);
        }

        } 
        // Ici un problème se pose dans le token 
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('profil');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $email,
    UserRepository $userRepository): Response 
    {
        $user = $this->getUser(); 
        if(!$user){
            $this->addFlash('danger', 'Veuillez vous connecter svp!');
            return $this->redirectToRoute('connexion');
        }

        if($user->isIsVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
        return $this->redirectToRoute('profil');
        //return $this->render('profile/index.html.twig', ['name'=>$user]);
        }
        // On crée le header 
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //On crée le Payload
        $payload = [
            'user_id' => $user->getId()
        ];

        //On génère le token
        $token = $jwt->generate($header, $payload,
        $this->getParameter('app.jwtsecret')) ;

        // do anything else you need here, like send an email
        $email->send(
            'no-reply@moayexchange.ci',
            $user->getEmail(),
            'Activation de votre compte sur le site MoayExchange',
            'register',
            compact('user', 'token'));
            $this->addFlash('success', 'Le mail a été envoyé avec succès');
        return $this->redirectToRoute('connexion');
    }
}
