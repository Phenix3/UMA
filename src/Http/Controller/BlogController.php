<?php

namespace App\Http\Controller;

use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Repository\CategoryRepository;
use App\Domain\Blog\Repository\PostRepository;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository,
        private CategoryRepository $categoryRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/', name: 'index')]
    public function index(Request $request)
    {
        $query = $this->postRepository->queryAll();
        $this->pageVariable
            ->setTitle('Blog')
            ->setSubtitle('')
            ->setMetaDescription('');

        return $this->renderListing($query, $request);
    }

    #[Route('/category/{slug}', name: 'category')]
    public function category(Category $category, Request $request)
    {
        $title = $category->getName();
        $query = $this->postRepository->queryAll($category);
        return $this->renderListing($query, $request, ['category' => $category]);
    }

    #[Route('/{slug<[a-z0-9\-.]+>}', name: 'show')]
    #[IsGranted('show', subject: 'post')]
    public function show(Post $post): Response
    {
        return $this->render('front/blog/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * Undocumented function
     *
     * @param string $title
     * @param Query $query
     * @param Request $request
     * @param array $params
     * @return Response
     */
    private function renderListing(Query $query, Request $request, array $params = []): Response
    {
        $page = $request->query->getInt('page', 1);
        $posts = $this->paginator->paginate(
            $query,
            $page,
            10
        );


        /* if ($page > 1) {
            $title .= ", page {$page}";
        } */
        if (0 === $posts->count()) {
            throw new NotFoundHttpException("No post corresponding to this page");
        }

        $categories = $this->categoryRepository->findWithCount();

        return $this->render('front/blog/index.html.twig', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            // 'page' => $page,
        ], $params));
    }
}
