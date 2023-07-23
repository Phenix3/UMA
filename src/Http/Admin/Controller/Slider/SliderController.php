<?php

namespace App\Http\Admin\Controller\Slider;

use App\Domain\Slider\Entity\Slider;
use App\Domain\Slider\Repository\SliderItemRepository;
use App\Http\Admin\Controller\CrudController;
use App\Http\Admin\Data\SliderCrudData;
use App\Http\Grid\SettingGrid;
use App\Http\Grid\Slider\SliderGrid;
use App\Http\Grid\Slider\SliderItemGrid;
use Doctrine\ORM\EntityManagerInterface;
use Prezent\Grid\GridFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/slider/sliders", name: "slider_slider_")]
class SliderController extends CrudController
{
    protected string $templatePath = 'slider/sliders';
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
        
        
        $this->pageVariable
            ->setTitle('Sliders list')
            ->setSubtitle('La liste de tous les sliders')
            ->addAction('add_slider', 'Add Slider', 'admin_slider_slider_new');


        return $this->crudIndex($query);
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $slider = new Slider();
        $data = new SliderCrudData($slider);

        
        $this->pageVariable
            ->setTitle('Add new slider')
            ->setSubtitle('Ajouter un nouveau slider')
            ->addAction('add_list', 'Slides List', 'admin_slider_slider_index');


        return $this->crudNew($data);
    }
    
    
    #[Route("/{id}/items", name: "items")]
    #[Entity('slider', expr: 'repository.findWithItems(id)')]
    public function items(Slider $slider, EntityManagerInterface $manager, GridFactory $gridFactory): Response
    {
        $grid = $gridFactory->createGrid(SliderItemGrid::class, ['routePrefix' => $this->routePrefix]);
        $gridData = $grid->createView();

        
        $this->pageVariable
            ->setTitle('Slider Item list')
            ->setSubtitle('La liste de tous les elements d\'un slider')
            ->addAction('add_slider', 'Add Slider Item', 'admin_slider_slider_item_new', ['slider_id' => $slider->getId()]);


        return $this->render('admin/slider/sliders/items.html.twig', compact('slider', 'gridData'));
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    public function delete(Slider $slider): Response
    {
        return $this->crudDelete($slider);
    }

    #[Route("/{id}", name: "edit")]
    public function edit(Slider $slider): Response
    {
        $data = new SliderCrudData($slider);


        $this->pageVariable
            ->setTitle('Edit Slider')
            ->setSubtitle('L')
            ->addAction('add_slider', 'Add Slider', 'admin_slider_slider_new')
            ->addAction(
                'add_slider_item',
                'Add Slider Item',
                'admin_slider_slider_item_new',
                ['slider_id' => $slider->getId()]
            );

        return $this->crudEdit($data);
    }
    
}
