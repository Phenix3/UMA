<?php

declare(strict_types=1);

namespace App\Domain\Application\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use function Symfony\Component\String\u;

/**
 * @property array<int, string> $locales
 */
final class UserLocaleSubscriber implements EventSubscriberInterface
{
    /** @var array<int, string> */
    private string|array $locales;
    private string $defaultLocale = 'fr';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        string $locales,
        string $defaultLocale
    ) {
        $this->locales = explode('|', trim($locales));
        if (null === $this->locales) {
            throw new \UnexpectedValueException('Not supported locale');
        }

        $this->defaultLocale = $defaultLocale;

        if (!\in_array($this->defaultLocale, $this->locales, true)) {
            throw new \UnexpectedValueException(
                sprintf('The default locale ("%s") must be one of "%s".', $this->defaultLocale, $locales)
            );
        }

        array_unshift($this->locales, $this->defaultLocale);
        $this->locales = array_unique($this->locales);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 21]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (
            !$event->isMainRequest()
            || '/' !== $request->getPathInfo()
        ) {
            return;
        }
        $referer = $request->headers->get('referer');

        if (
            null !== $referer
            && u($referer)
                ->ignoreCase()
                ->startsWith($request->getSchemeAndHttpHost())
        ) {
            return;
        }

        $preferredLanguage = $request->getPreferredLanguage($this->locales);

        if ($preferredLanguage !== $this->defaultLocale) {
            $response = new RedirectResponse(
                $this->urlGenerator->generate(
                    'home_index',
                    ['_locale' => $preferredLanguage]
                )
            );
            $event->setResponse($response);
        } else {
            $request->getSession()->set('_locale', $preferredLanguage);
            $request->attributes->set('_locale', $preferredLanguage);
            $request->setLocale($preferredLanguage);
        }
    }
}
