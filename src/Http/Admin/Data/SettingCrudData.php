<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Validator\Slug;
use App\Domain\Application\Entity\Setting;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property Setting $entity
 */
class SettingCrudData extends AutomaticCrudData
{
    public ?string $keyName = '';

    public ?string $value = '';
}
