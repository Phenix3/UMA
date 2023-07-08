<?php declare(strict_types=1);

namespace App\Http\Api\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Domain\Contact\ContactData;
use App\Domain\Contact\ContactService;
use App\Domain\Contact\TooManyContactException;
use App\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "api_contact", methods: ['POST'])]
    public function create(
        DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
        ContactService $contactService,
        Request $request
    ): JsonResponse 
    {
        $data = json_decode((string) $request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $contactData = $denormalizer->denormalize($data, ContactData::class);
        $validator->validate($contactData);
        try {
            $contactService->send($contactData, $request);
        } catch (TooManyContactException) {
            return $this->json([
                'title' => 'Vous avez fait trop de demandes de contact consécutives.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
