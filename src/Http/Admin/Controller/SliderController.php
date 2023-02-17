<?php

namespace App\Http\Admin\Controller;

use App\Domain\Slider\Entity\Slider;
use App\Http\Admin\Data\SliderCrudData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Prezent\Grid\GridFactory;
use App\Http\Grid\SettingGrid;
use App\Http\Grid\Slider\SliderGrid;
use App\Http\Grid\Slider\SliderItemGrid;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Slider\Repository\SliderItemRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

#[Route("/slider/slider", name: "slider_slider_")]
class SliderController extends CrudController
{
    protected string $templatePath = 'slider';
    protected string $menuItem = 'slider';
    protected string $entity = Slider::class;
    protected string $routePrefix = 'admin_slider_slider';
    protected string $searchField = 'name';

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderBy('row.name', 'DESC')
            ;
        $grid = $gridFactory->createGrid(SliderGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();
        return $this->crudIndex($query);
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $slider = new Slider();
        $data = new SliderCrudData($slider);

        return $this->crudNew($data);
    }
    
    
    #[Route("/{id<\d+>}/items", name: "items")]
    #[Entity('slider', expr: 'repository.findWithItems(id)')]
    public function items(Slider $slider, EntityManagerInterface $manager, GridFactory $gridFactory): Response
    {
        $grid = $gridFactory->createGrid(SliderItemGrid::class, ['routePrefix' => $this->routePrefix]);
        $gridData = $grid->createView();
        return $this->render('admin/slider/items.html.twig', compact('slider', 'gridData'));
    }

    #[Route("/{id<\d+>}", name: "delete", methods: ["DELETE"])]
    public function delete(Slider $slider): Response
    {
        return $this->crudDelete($slider);
    }

    #[Route("/{id<\d+>}", name: "edit")]
    public function edit(Slider $slider): Response
    {
        $data = new SliderCrudData($slider);

        return $this->crudEdit($data);
    }
    
}
