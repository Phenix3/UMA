<?php

declare(strict_types=1);

namespace App\Helper\Paginator;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PageOutOfBoundException extends BadRequestHttpException {}
