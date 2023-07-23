<?php

namespace App\Http\Admin\Controller\Blog;

use App\Domain\Blog\Entity\Category;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\CategoryCrudData;
use App\Http\Grid\Blog\CategoryGrid;
use Prezent\Grid\GridFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/blog/categories", name: "blog_category_")]
class CategoryController extends CrudController
{
    protected string $templatePath = 'blog/categories';
    protected string $menuItem = 'categories';
    protected string $entity = Category::class;
    protected string $routePrefix = 'admin_blog_category';
    protected string $searchField = 'name';

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderBy('row.id', 'DESC');

        $grid = $gridFactory->createGrid(CategoryGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();

        $this->pageVariable
            ->setTitle('Manage Blog Categories')
            ->setSubtitle('Manage all blog category')
            ->addAction('add_category', 'Add new category', 'admin_blog_category_new');

        return $this->crudIndex($query);
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $categories = new Category();
        $data = new CategoryCrudData($categories);

        
        $this->pageVariable
            ->setTitle('Add Blog Categories')
            ->setSubtitle('Add a blog category')
            ->addAction('list_category', 'List categories', 'admin_blog_category_index');


        return $this->crudNew($data);
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    public function delete(Category $categories): Response
    {
        return $this->crudDelete($categories);
    }

    #[Route("/{id}", name: "edit")]
    public function edit(Category $categories): Response
    {
        $data = new CategoryCrudData($categories);

        
        $this->pageVariable
            ->setTitle('Edit Blog Categories')
            ->setSubtitle('Edit a blog category')
            ->addAction('list_category', 'List categories', 'admin_blog_category_index');


        return $this->crudEdit($data);
    }
}
