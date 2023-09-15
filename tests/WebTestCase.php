<?php

declare(strict_types=1);

namespace App\Tests;

use App\Domain\Auth\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @internal
 *
 * @coversNothing
 */
final class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    use FixturesTrait;

    protected KernelBrowser $client;
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient([], ['HTTP_HOST' => '127.0.0.1:8000']);

        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $this->em = $em;
        // $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->em->clear();
        parent::tearDown();
    }

    public function jsonRequest(string $method, string $url, array $data = null): string
    {
        $this->client->request($method, $url, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ], $data ? json_encode($data, JSON_THROW_ON_ERROR) : null);

        return $this->client->getResponse()->getContent();
    }

    /**
     * Vérifie si on a un message de succès.
     */
    public function expectAlert(string $type, string $message = null): void
    {
        self::assertSame(
            1,
            $this->client->getCrawler()->filter(
                "alert-message[type=\"{$type}\"], alert-floating[type=\"{$type}\"]"
            )->count()
        );
        if ($message) {
            self::assertStringContainsString(
                $message,
                $this->client->getCrawler()->filter(
                    "alert-message[type=\"{$type}\"], alert-floating[type=\"{$type}\"]"
                )->text()
            );
        }
    }

    /**
     * Vérifie si on a un message d'erreur.
     */
    public function expectErrorAlert(): void
    {
        self::assertSame(
            1,
            $this->client->getCrawler()->filter(
                'alert-message[type="danger"], alert-message[type="error"]'
            )->count()
        );
    }

    /**
     * Vérifie si on a un message de succès.
     */
    public function expectSuccessAlert(): void
    {
        $this->expectAlert('success');
    }

    public function expectFormErrors(int $expectedErrors = null): void
    {
        if (null === $expectedErrors) {
            self::assertTrue(
                $this->client->getCrawler()->filter('.form-error')->count() > 0,
                'Form errors missmatch.'
            );
        } else {
            self::assertSame(
                $expectedErrors,
                $this->client->getCrawler()->filter('.form-error')->count(),
                'Form errors missmatch.'
            );
        }
    }

    public function expectH1(string $title): void
    {
        $crawler = $this->client->getCrawler();
        self::assertSame(
            $title,
            $crawler->filter('h1')->text(),
            '<h1> missmatch'
        );
    }

    public function expectTitle(string $title): void
    {
        $crawler = $this->client->getCrawler();
        self::assertSame(
            $title.' | '.$_ENV['APP_NAME'],
            $crawler->filter('title')->text(),
            '<title> missmatch',
        );
    }

    public function login(?User $user): void
    {
        if (null === $user) {
            return;
        }
        $this->client->loginUser($user);
    }

    public function setCsrf(string $key): string
    {
        $csrf = uniqid();
        self::getContainer()->get(TokenStorageInterface::class)->setToken($key, $csrf);

        return $csrf;
    }
}
