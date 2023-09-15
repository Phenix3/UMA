<?php

declare(strict_types=1);

namespace App\Http\Grid\Type;

use Prezent\Grid\BaseElementType;
use Prezent\Grid\ElementView;
use Prezent\Grid\Extension\Core\Type\StringType;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageType extends BaseElementType
{
    public function __construct(private UploaderHelper $uploaderHelper) {}

    public function bindView(ElementView $view, $item): void
    {
        $view->vars['value'] = $this->uploaderHelper->asset($item, 'imageFile');
    }

    public function getParent(): string
    {
        return StringType::class;
    }
}
