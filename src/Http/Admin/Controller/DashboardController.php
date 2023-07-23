<?php declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
#[Route('/dashboard', name: 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response 
    {
        $this->pageVariable
            ->setTitle('Admin Dashboard');
        return $this->render('admin/dashboard/index.html.twig');
    }
}
