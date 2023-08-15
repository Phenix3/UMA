<?php

namespace App\Http\Admin\Controller;

use App\Domain\Application\Entity\Setting;
use App\Domain\Application\Event\SettingCreatedEvent;
use App\Domain\Application\Event\SettingDeletedEvent;
use App\Http\Admin\Data\SettingCrudData;
use App\Http\Grid\SettingGrid;
use Prezent\Grid\GridFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/setting", name: "setting_")]
class SettingController extends CrudController
{
    protected string $templatePath = 'setting';
    protected string $menuItem = 'setting';
    protected string $entity = Setting::class;
    protected string $routePrefix = 'admin_setting';
    protected string $searchField = 'name';

    protected array $events = [
        'update' => SettingCreatedEvent::class,
        'delete' => SettingDeletedEvent::class,
        'create' => SettingCreatedEvent::class,
    ];

    #[Route("/", name: "index")]
    public function index(GridFactory $gridFactory): Response
    {
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderBy('row.keyName', 'DESC');
            
        $grid = $gridFactory->createGrid(SettingGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();

        $this->pageVariable
            ->setTitle('Manage Settings')
            ->setSubtitle('Manage all settings')
            ->addAction('add_setting', 'Add new settting', 'admin_setting_new');
            
        return $this->crudIndex($query);
    }

    #[Route("/new", name: "new")]
    public function new(): Response
    {
        $setting = new Setting();
        $data = new SettingCrudData($setting);

        $this->pageVariable
            ->setTitle('Add Setting')
            ->setSubtitle('Add new settings')
            ->addAction('add_setting', 'Manage setttings', 'admin_setting_index');

        return $this->crudNew($data);
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    #[ParamConverter('setting', options: ['keyName' => 'id'])]
    public function delete(Setting $setting): Response
    {
        return $this->crudDelete($setting);
    }

    // #[ParamConverter('setting', class: Setting::class, options: ['keyName' => 'id'])]
    #[Route("/{id}", name: "edit")]
    #[Entity('setting', expr: "repository.find(id)")]
    public function edit(Setting $setting): Response
    {
        $data = new SettingCrudData($setting);

        $this->pageVariable
            ->setTitle('Edit Setting')
            ->setSubtitle('Edit settings')
            ->addAction('edit_setting', 'Manage setttings', 'admin_setting_index');

        return $this->crudEdit($data);
    }
}
