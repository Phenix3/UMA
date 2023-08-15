<?php declare(strict_types=1);

namespace App\Tests\Http\Api\Controller;

use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testIndex(): void
    {
        $this->loadFixtures([]);
        $this->client->request('GET', '/demo');
        $this->assertResponseStatusCodeSame(200);
        $this->expectH1('Demo');
        $this->expectTitle('Demo');
    }
}
