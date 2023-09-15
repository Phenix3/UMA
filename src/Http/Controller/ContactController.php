<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'request')]
    public function index(): Response
    {
        $this->pageVariable
            ->setTitle('Contact')
        ;

        return $this->render('front/pages/contact.html.twig');
    }
}
