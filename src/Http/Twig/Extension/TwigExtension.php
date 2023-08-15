<?php

namespace App\Http\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;

class TwigExtension extends AbstractExtension
{
    public function __construct(private UrlMatcherInterface $urlMatcher, private UrlGeneratorInterface $urlGenerator)
    {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('icon', [$this, 'svgIcon'], ['is_safe' => ['html']]),
            new TwigFunction('menu_active', [$this, 'menuActive'], ['is_safe' => ['html'], 'needs_context' => true]),
        ];
    }

    /**
     * Génère le code HTML pour une icone SVG.
     */
    public function svgIcon(string $name, ?int $size = null): string
    {
        $attrs = '';
        if ($size) {
            $attrs = " width=\"{$size}px\" height=\"{$size}px\"";
        }

        return <<<HTML
        <em class="{$name}"{$attrs}></em>
        HTML;
    }

    private function matchRoute(Request $request, array $patterns)
    {
        return $this->is($request, $patterns);
    }

    /**
     * Ajout une class is-active pour les éléments actifs du menu.
     *
     * @param array<string,mixed> $context
     */
    public function menuActive(array $context, array $patterns, ?string $activeClass = 'active current-page'): string
    {
        $request = $context['app']->getRequest();
        return $this->matchRoute($request, $patterns) ? $activeClass : '';
       /* if (($context['menu'] ?? null) === $name) {
            return ' aria-current="page"';
        }
*/
        // return '';
    }

    private function isPath($paths)
    {
        return $this->is($paths);
    }

    private function isRoute()
    {

    }

    private function decodedPath(Request $request)
    {
        return rawurldecode($this->path($request));
    }

    public function path(Request $request)
    {
        $pattern = trim($request->getPathInfo(), '/');

        return $pattern === '' ? '/' : $pattern;
    }

     /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $haystack
     * @param  string|iterable<string>  $needles
     * @param  bool  $ignoreCase
     * @return bool
     */
    public static function contains($haystack, $needles, $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack);
        }

        if (! is_iterable($needles)) {
            $needles = (array) $needles;
        }

        foreach ($needles as $needle) {
            if ($ignoreCase) {
                $needle = mb_strtolower($needle);
            }

            if ($needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|iterable<string>  $pattern
     * @param  string  $value
     * @return bool
     */
    public static function strIs($pattern, $value): bool
    {
        $value = (string) $value;

        if (! is_iterable($pattern)) {
            $pattern = [$pattern];
        }

        foreach ($pattern as $pattern) {
            $pattern = (string) $pattern;

            // If the given value is an exact match we can of course return true right
            // from the beginning. Otherwise, we will translate asterisks and do an
            // actual pattern match against the two strings to see if they match.
            if ($pattern === $value) {
                return true;
            }

            $pattern = preg_quote($pattern, '#');

            // Asterisks are translated into zero-or-more regular expression wildcards
            // to make it convenient to check if the strings starts with the given
            // pattern such as "library/*", making any string check convenient.
            $pattern = str_replace('\*', '.*', $pattern);

            if (preg_match('#^'.$pattern.'\z#u', $value) === 1) {
                return true;
            }
        }

        return false;
    }

    private function is(Request $request, array $patterns)
    {
        $path = $this->decodedPath($request);
        $is = collect($patterns)->contains(fn ($pattern) => $this->strIs($pattern, $path));
        // dd($path);
        return $is;
    }


}
