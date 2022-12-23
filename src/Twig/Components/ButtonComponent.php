<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('button')]
final class ButtonComponent
{
    public string $type = 'button';
    public string $label;
}
