<?php

declare(strict_types=1);

namespace App\Infrastructure\Enum;

use App\Infrastructure\Enum\Traits\UtilsTrait;

enum UserRoleEnum: string
{
    use UtilsTrait;

    case SuperAdmin = 'ROLE_SUPER_ADMIN';
    case Admin = 'ROLE_ADMIN';
    case User = 'ROLE_USER';
    case AllowedToSwitch = 'ROLE_ALLOWED_TO_SWITCH';
}
