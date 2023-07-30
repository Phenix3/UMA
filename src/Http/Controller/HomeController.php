<?php

namespace App\Http\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        $this->pageVariable
            ->setTitle('Home page')
            ->setMetaDescription('La description');
        return $this->render('front/home/index.html.twig');
    }
}