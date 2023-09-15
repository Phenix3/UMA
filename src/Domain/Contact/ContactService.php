<?php

declare(strict_types=1);

namespace App\Domain\Contact;

use App\Domain\Contact\Entity\ContactRequest;
use App\Domain\Contact\Repository\ContactRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class ContactService
{
    public function __construct(
        private readonly ContactRequestRepository $repository,
        private readonly EntityManagerInterface $em,
        private readonly MailerInterface $mailer
    ) {}

    public function send(ContactData $data, Request $request): void
    {
        // dump($data);
        $contactRequest = (new ContactRequest())
            ->setRawIp($request->getClientIp())
            ->setName($data->name)
            ->setEmail($data->email)
            ->setContent($data->content)
        ;
        $lastRequest = $this->repository->findLastRequestForIp($contactRequest->getIp());
        if ($lastRequest && $lastRequest->getCreatedAt() > new \DateTime('- 1 hour')) {
            throw new TooManyContactException();
        }
        if (null !== $lastRequest) {
            $lastRequest->setCreatedAt(new \DateTime());
        } else {
            $this->em->persist($contactRequest);
        }
        $this->em->flush();
        $message = (new Email())
            ->text($data->content)
            ->subject("UMA::Contact : {$data->name}")
            ->from('noreply@univ-maroua.cm')
            ->replyTo(new Address($data->email, $data->name))
            ->to('contact@univ-maroua.cm')
        ;
        $this->mailer->send($message);
    }
}
