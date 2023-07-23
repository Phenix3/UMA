<?php

namespace App\Infrastructure\Enum;

use App\Infrastructure\Enum\Traits\UtilsTrait;

enum ColorTypeEnum: string
{
    use UtilsTrait;

    case Error = 'error';
    case Info = 'info';
    case Primary = 'primary';
    case Secondary = 'secondary';
    case Success = 'success';
    case Warning = 'warning';
}
