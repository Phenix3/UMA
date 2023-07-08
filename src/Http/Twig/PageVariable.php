<?php

namespace App\Http\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class PageVariable
{

    private ?string $title;

    private ?string $metaKeywords;

    private ?string $metaDescription;

    private array $actions = [];

    private array $extra = [];

    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private UrlGeneratorInterface $urlGenerator)
    {
    }


    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        /* if (!$this->title) {
            throw new \RuntimeException("The 'page.title' is not available and should be set");
        } */
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of metaKeywords
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords ?? '';
    }

    /**
     * Set the value of metaKeywords
     *
     * @return  self
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get the value of metaDescription
     */
    public function getMetaDescription()
    {
        return $this->metaDescription ?? '';
    }

    /**
     * Set the value of metaDescription
     *
     * @return  self
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Set the value of extra
     *
     * @return  self
     */
    public function setExtra(array $extra)
    {
        $this->extra = $extra;

        return $this;
    }

    public function addExtra(string $key, string $value)
    {
        $this->extra[$key] = $value;
    }

    public function getExtra(?string $key = null, ?string $default = null): string|array
    {
        if ($key) {
            return $this->extra[$key] ?? $default;
        }
        return $this->extra;
    }

    public function setSubtitle(string $value): self
    {
        $this->addExtra('subtitle', $value);
        return $this;
    }

    public function getSubtitle()
    {
        return $this->getExtra('subtitle');
    }

    /**
     * Get the value of actions
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * Set the value of actions
     *
     * @return  self
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param  string     $key
     * @param  string     $label
     * @param  string     $target http link or routeName
     * @param  array|null $routeParams
     * @return self
     */
    public function addAction(string $key, string $label, string $target, ?array $routeParams = []): self
    {
        $data = [];
        try {
            $this->urlMatcher->match($target);
            $data['target'] = $target;
        } catch (\Throwable $th) {
            try {
                $data['target'] = $this->urlGenerator->generate($target, $routeParams);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
            
        $data['label'] = $label;
        $this->actions[$key] = $data;
        return $this;
    }
}
