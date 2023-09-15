<?php

declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Page\Entity\Page;
use App\Domain\Page\Event\PageCreatedEvent;
use App\Domain\Page\Event\PageDeletedEvent;
use App\Domain\Page\Event\PageUpdatedEvent;
use App\Http\Admin\Form\PageForm;
use App\Http\Grid\PageGrid;
use Prezent\Grid\GridFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pages', name: 'page_')]
class PageController extends CrudController
{
    protected string $templatePath = 'pages';
    protected string $menuItem = 'page';
    protected string $entity = Page::class;
    protected string $routePrefix = 'admin_page';
    protected string $searchField = 'title';

    protected array $events = [
        'update' => PageUpdatedEvent::class,
        'delete' => PageDeletedEvent::class,
        'create' => PageCreatedEvent::class,
    ];

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GridFactory $gridFactory): Response
    {
        $grid = $gridFactory->createGrid(PageGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();

        $this->pageVariable
            ->setTitle('Liste des pages')
            ->setMetaDescription('')
            ->addAction('add_page', 'New Page', 'admin_page_new')
        ;

        return $this->crudIndex();
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pageEntity = new Page();
        $form = $this->createForm(PageForm::class, $pageEntity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($pageEntity);
            $this->em->flush();

            if ($this->events['create'] ?? null) {
                $this->dispatcher->dispatch(new $this->events['create']($pageEntity));
            }

            return $this->redirectToRoute('admin_page_index');
        }

        $this->pageVariable
            ->setTitle('Nouvelle page')
        ;

        return $this->render('admin/pages/new.html.twig', compact('form', 'pageEntity'));
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $pageEntity): Response
    {
        $form = $this->createForm(PageForm::class, $pageEntity)->handleRequest($request);
        $old = clone $pageEntity;
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            if ($this->events['update'] ?? null) {
                $this->dispatcher->dispatch(new $this->events['update']($pageEntity, $old));
            }

            $this->addFlash('success', 'alerts.page_updated');

            return $this->redirectToRoute('admin_page_index');
        }

        $this->pageVariable
            ->setTitle($pageEntity->getTitle())
            ->setMetaDescription($pageEntity->getDescription())
        ;

        return $this->render('admin/pages/edit.html.twig', compact('form', 'pageEntity'));
    }

    #[Route('/{id}', name: 'delete', methods: 'POST|DELETE')]
    public function delete(Page $page): Response
    {
        return $this->crudDelete($page, 'admin_page_index');
    }
}
