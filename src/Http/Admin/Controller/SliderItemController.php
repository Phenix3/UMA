<?php

namespace App\Http\Admin\Controller;

use App\Domain\Slider\Entity\SliderItem;
use App\Http\Admin\Data\SliderItemCrudData;
use App\Http\Grid\Slider\SliderItemGrid;
use Prezent\Grid\GridFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/slider/slider-item", name: "slider_slider_item_")]
class SliderItemController extends CrudController
{
    protected string $templatePath = 'slider_item';
    protected string $menuItem = 'slider-item';
    protected string $entity = SliderItem::class;
    protected string $routePrefix = 'admin_slider_slider_item';
    protected string $searchField = 'name';

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderBy('row.id', 'DESC')
            ;
        $grid = $gridFactory->createGrid(SliderItemGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();

        $this->pageVariable
            ->setTitle('Slider Item list')
            ->setSubtitle('La liste de tous les elements d\'un slider')
            ->addAction('add_slider', 'Add Slider', 'admin_slider_slider_item_new');


        return $this->crudIndex($query);
    }

    #[Route("/new", name: "new")]
    public function new(Request $request): Response
    {
        $sliderItem = new SliderItem();
        $data = new SliderItemCrudData($sliderItem);
        $form = $this->createForm($data->getFormClass(), $sliderItem);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($sliderItem);
            $this->em->flush();
            if ($this->events['create'] ?? null) {
                $this->dispatcher->dispatch(new $this->events['create']($data->getEntity()));
            }
            
            $this->addFlash('success', 'Le contenu a bien été créé');
            
            return $this->redirectToRoute($this->routePrefix.'_edit', ['id' => $sliderItem->getId()]);
        }

        
        $this->pageVariable
           ->setTitle('Add new Slider Item')
           ->setSubtitle('La liste de tous les elements d\'un slider')
           ->addAction('slider_item_list', 'Add Slider', 'admin_slider_slider_item_index');


        return $this->render('admin/slider_item/new.html.twig', compact('form', 'sliderItem'));
    }

    #[Route("/{id<\d+>}", name: "delete", methods: ["DELETE"])]
    public function delete(SliderItem $sliderItem): Response
    {
        return $this->crudDelete($sliderItem);
    }

    #[Route("/{id<\d+>}", name: "edit")]
    public function edit(SliderItem $sliderItem): Response
    {
        $data = new SliderItemCrudData($sliderItem);

        $this->pageVariable
           ->setTitle('Edit Slider Item')
           ->setSubtitle('La liste de tous les elements d\'un slider')
           ->addAction('add_slider', 'Add Slider', 'admin_slider_slider_item_index');


        return $this->crudEdit($data);
    }
}
