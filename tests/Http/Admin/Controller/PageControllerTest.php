<?php

declare(strict_types=1);

/**
 * @var Crawler $crawler
 */

use Symfony\Component\DomCrawler\Crawler;

test('Able to list available pages', function (): void {
    $this->client->request('GET', '/admin/pages/');
    $this->assertResponseStatusCodeSame(200);
    $this->expectTitle('Liste des pages');
});

test('Able to create new page', function (): void {
    /** @var Crawler $crawler */
    $crawler = $this->client->request('GET', '/admin/pages/new');
    $form = $crawler->selectButton('Sauvegarder')->form();
    $form->setValues([
        'page_form' => [
            'title' => '',
            'description' => '',
            'content' => '',
        ],
    ]);
    $this->client->submit($form);
    $this->expectFormErrors(0);
    $this->assertReponseRedirect('/admin/pages/');
    $this->client->followRedirect();
});
