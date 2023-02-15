<?php

namespace App\Http\Admin\Controller;

use App\Domain\Application\Entity\Setting;
use App\Http\Admin\Data\SettingCrudData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Prezent\Grid\GridFactory;
use App\Http\Grid\SettingGrid;

/**
 * @Route("/setting", name="setting_")
 */
class SettingController extends CrudController
{
    protected string $templatePath = 'setting';
    protected string $menuItem = 'setting';
    protected string $entity = Setting::class;
    protected string $routePrefix = 'admin_setting';
    protected string $searchField = 'name';

    /**
     * @Route("/", name="index")
     */
    public function index(GridFactory $gridFactory): Response
    {
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderBy('row.keyName', 'DESC')
            ;
        $grid = $gridFactory->createGrid(SettingGrid::class, ['routePrefix' => $this->routePrefix]);
        $this->vars['gridData'] = $grid->createView();
        return $this->crudIndex($query);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(): Response
    {
        $setting = new Setting();
        $data = new SettingCrudData($setting);

        return $this->crudNew($data);
    }

    /**
     * @Route("/{keyName}", name="delete", methods={"DELETE"})
     */
    public function delete(Setting $setting): Response
    {
        return $this->crudDelete($setting);
    }

    /**
     * @Route("/{keyName}", name="edit")
     */
    public function edit(Setting $setting): Response
    {
        $data = new SettingCrudData($setting);

        return $this->crudEdit($data);
    }
}
