<?php

namespace App\Http\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Domain\Slider\Entity\Slider;
use Doctrine\ORM\EntityManagerInterface;

#[AsTwigComponent('slider')]
final class SliderComponent
{
    public string $slug;
    
    public function __construct(private EntityManagerInterface $manager) {}
    
    public function getSlider()
    {
        $repo = $this->manager->getRepository(Slider::class);
        return $repo->findWithItemsBy(['slug' => $this->slug]);
    }
}
