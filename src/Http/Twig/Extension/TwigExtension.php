<?php

declare(strict_types=1);

namespace App\Http\Twig\Extension;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function __construct(private UrlMatcherInterface $urlMatcher, private UrlGeneratorInterface $urlGenerator) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'active_locale',
                [$this, 'activeLocale'],
                ['is_safe' => ['html'], 'needs_context' => true]
            ),
            new TwigFunction('isoToEmoji', [$this, 'isoToEmoji'], ['is_safe' => ['html']]),
            new TwigFunction('menu_active', [$this, 'menuActive'], ['is_safe' => ['html'], 'needs_context' => true]),
        ];
    }

    /**
     * Génère le code HTML pour une icone SVG.
     */
    public function activeLocale(array $context, string $locale): string
    {
        /** @var Request $request */
        $request = $context['app']->getRequest();
        $requestLocale = $request->getLocale();

        return $locale === $requestLocale ? ' active ' : '';
    }

    public function isoToEmoji(string $code)
    {
        return implode(
            '',
            array_map(
                static fn ($letter) => mb_chr(\ord($letter) % 32 + 0x1F1E5),
                str_split($code)
            )
        );
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

    public function path(Request $request)
    {
        $pattern = trim($request->getPathInfo(), '/');

        return '' === $pattern ? '/' : $pattern;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string                  $haystack
     * @param iterable<string>|string $needles
     * @param bool                    $ignoreCase
     */
    public static function contains($haystack, $needles, $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack);
        }

        if (!is_iterable($needles)) {
            $needles = (array) $needles;
        }

        foreach ($needles as $needle) {
            if ($ignoreCase) {
                $needle = mb_strtolower($needle);
            }

            if ('' !== $needle && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param iterable<string>|string $pattern
     * @param string                  $value
     */
    public static function strIs($pattern, $value): bool
    {
        $value = (string) $value;

        if (!is_iterable($pattern)) {
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

            if (1 === preg_match('#^'.$pattern.'\z#u', $value)) {
                return true;
            }
        }

        return false;
    }

    private function matchRoute(Request $request, array $patterns)
    {
        return $this->is($request, $patterns);
    }

    private function isRoute(): void {}

    private function decodedPath(Request $request)
    {
        return rawurldecode($this->path($request));
    }

    private function is(Request $request, array $patterns)
    {
        $path = $this->decodedPath($request);

        return collect($patterns)->contains(fn ($pattern) => $this->strIs($pattern, $path));
        // dd($path);
    }
}
