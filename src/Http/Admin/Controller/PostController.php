<?php

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
use App\Http\Admin\Data\PostCrudData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Prezent\Grid\GridFactory;
use App\Http\Grid\Blog\PostGrid;

/**
 * @Route("/blog/post", name="blog_post_")
 */
class PostController extends CrudController
{
    protected string $templatePath = 'blog/post';
    protected string $menuItem = 'blog_post';
    protected string $entity = Post::class;
    protected string $routePrefix = 'admin_blog_post';
    protected string $searchField = 'name';

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        $grid = $gridFactory->createGrid(PostGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();
        return $this->crudIndex();
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $post = new Post();
        $data = new PostCrudData($post);

        return $this->crudNew($data);
    }

    #[Route("/{id<\d+>}", name: "delete", methods: ["DELETE"])]
    public function delete(Post $post): Response
    {
        return $this->crudDelete($post);
    }

   #[Route("/{id<\d+>}", name: "edit")]
    public function edit(Post $post): Response
    {
        $data = new PostCrudData($post);

        return $this->crudEdit($data);
    }
}
