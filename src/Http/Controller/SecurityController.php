<?php

namespace App\Http\Controller;

use App\Http\Admin\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/security', name: 'security_')]
class SecurityController extends BaseController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('danger', 'alerts.already_logged_in');
            return $this->redirect('/');
        }

        $this->pageVariable
            ->setTitle('Login');
        return $this->render('front/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}