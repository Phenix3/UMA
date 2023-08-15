<?php

namespace App\Http\Admin\Controller\Blog;

use App\Domain\Blog\Entity\Post;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\PostCrudData;
use App\Http\Grid\Blog\PostGrid;
use Prezent\Grid\GridFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 #[Route("/blog/posts", name: "blog_post_")]
class PostController extends CrudController
{
    protected string $templatePath = 'blog/posts';
    protected string $menuItem = 'blog_post';
    protected string $entity = Post::class;
    protected string $routePrefix = 'admin_blog_post';
    protected string $searchField = 'name';

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        $grid = $gridFactory->createGrid(PostGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();

        $this->pageVariable
            ->setTitle('Blog posts list')
            ->setSubtitle('You have')
            ->addAction('add_post', 'Add Post', 'admin_blog_post_new');

        // dump($this->pageVariable);

        return $this->crudIndex();
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $post = new Post();
        $data = new PostCrudData($post);

        
        $this->pageVariable
            ->setTitle('Add List')
            ->setSubtitle('Input new Patient information carefully.')
            ->addAction('add_post', 'Add List', 'admin_blog_post_index');


        return $this->crudNew($data);
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    public function delete(Post $post): Response
    {
        return $this->crudDelete($post);
    }

   #[Route("/{id}", name: "edit")]
    public function edit(Post $post): Response
    {
        $data = new PostCrudData($post);

        
        $this->pageVariable
            ->setTitle('Edit post')
            ->setSubtitle('Input new Patient information carefully.')
            ->addAction('edit_post', 'Post List', 'admin_blog_post_index');


        return $this->crudEdit($data);
    }
}
