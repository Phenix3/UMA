<?php

declare(strict_types=1);

use App\Domain\Page\Entity\Page;
use App\Domain\Page\Entity\PageTranslation;

it('Feature test 1', function (): void {
    $repo = $this->em->getRepository(Page::class);
    $pages = $repo->findAll();
    echo $repo::class;
    $this->assertTrue(true);
    expect(count($pages))->toBeInt()->toBe(0);
    // $this->asset
});

it('test 2', static function (): void {
    $r = 1 + 4;

    expect($r)->toBeInt()->toBe(5);
});

it('Able to save translated page', function (): void {
    $repo = $this->em->getRepository(Page::class);

    $page = new Page();
    $page->translate()->setTitle('Title 1 en');
    $page->translate()->setSlug('title-1-en');
    $page->translate()->setDescription('Description 1 en');
    $page->translate()->setContent('COntent 1 en');
    $page->mergeNewTranslations();
    $repo->save($page, true);

    $pages = $repo->findAll();

    $repoTr = $this->em->getRepository(PageTranslation::class);

    $tpages = $repoTr->findAll();

    expect(count($pages))->toBeInt()->toBe(1);
    expect(count($tpages))->toBeInt()->toBe(1);
});

it('Able to save multiple translation of the same page', function (): void {
    $repo = $this->em->getRepository(Page::class);

    $page = new Page();
    $page->translate()->setTitle('Title 1 en');
    $page->translate()->setSlug('title-1-en');
    $page->translate()->setDescription('Description 1 en');
    $page->translate()->setContent('COntent 1 en');

    $page->translate('fr')->setTitle('Title 1 en');
    $page->translate('fr')->setSlug('title-1-en');
    $page->translate('fr')->setDescription('Description 1 en');
    $page->translate('fr')->setContent('COntent 1 en');

    $page->translate('de')->setTitle('Title 1 en');
    $page->translate('de')->setSlug('title-1-en');
    $page->translate('de')->setDescription('Description 1 en');
    $page->translate('de')->setContent('COntent 1 en');

    $page->mergeNewTranslations();
    $repo->save($page, true);

    $pages = $repo->findAll();

    $repoTr = $this->em->getRepository(PageTranslation::class);

    $tpages = $repoTr->findAll();

    $page = $repo->findAll()[0];

    expect(count($pages))->toBeInt()->toBe(1);
    expect(count($tpages))->toBeInt()->toBe(3);
});
