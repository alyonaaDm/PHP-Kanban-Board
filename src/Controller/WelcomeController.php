<?php

namespace App\Controller;

use App\Service\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_welcome')]
    public function index(Request $request, AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('welcome/login.html.twig', [
            'controller_name' => 'WelcomeController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/welcome/register', name:'welcome_register')]
    public function register(
        UserPasswordHasherInterface $userPasswordHasher,
        UserServices $userServices
    )
    {
        $newUser = $userServices->createUser($_POST, $userPasswordHasher);
        $userServices->saveUser($newUser);
        return $this->render('welcome/login.html.twig');
    }

    #[Route('/welcome/registation-page', name: 'welcome_registration_page')]
    public function registrationPage()
    {
        return $this->render('welcome/registration.html.twig');
    }

}
