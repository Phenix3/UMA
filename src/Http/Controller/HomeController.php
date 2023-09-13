<?php

namespace App\Http\Controller;

use App\Domain\Blog\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\LocaleSwitcher;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository)
    {
        $recentPosts = $postRepository->findRecent(3);

        $this->pageVariable
            ->setTitle('Home page')
            ->setMetaDescription('La description');

        return $this->render('front/home/index.html.twig', compact('recentPosts'));
    }

    public function changeLocale(LocaleSwitcher $localeSwitcher): Response
    {

        return $this->redirectBack('home_index');
    }
}
