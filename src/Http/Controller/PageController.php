<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Page\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'page_')]
final class PageController extends AbstractController
{
    #[Route('/{slug<[a-z0-9\-]+>}', name: 'show', priority: 0)]
    public function show(Request $request, Page $page): Response
    {
        $locale = $request->getLocale();
        $page = $page->translate($locale);

        return $this->render('front/pages/show.html.twig', compact('page'));
    }
}
