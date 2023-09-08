<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Application\Entity\Setting;

/**
 * @property Setting $entity
 */
class SettingCrudData extends AutomaticCrudData
{
    public ?string $keyName = '';

    public ?string $value = '';
}
