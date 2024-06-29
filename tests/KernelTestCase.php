<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as BaseKernelTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class KernelTestCase extends BaseKernelTestCase
{
    use FixturesTrait;

    protected KernelBrowser $client;
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        parent::setUp();
    }

    public function remove(object $entity): void
    {
        $this->em->remove($this->em->getRepository($entity::class)->find($entity->getId()));
    }
}
