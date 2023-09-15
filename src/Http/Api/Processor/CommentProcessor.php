<?php

declare(strict_types=1);

namespace App\Http\Api\Processor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Domain\Auth\Entity\User;
use App\Domain\Comment\CommentService;
use App\Http\Api\Resource\CommentResource;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private ProcessorInterface $removeProcessor,
        private readonly ValidatorInterface $validator,
        private readonly Security $security,
        private readonly CommentService $service
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // dd($data);
        if ($operation instanceof DeleteOperationInterface) {
            return $this->remove($data, $context);
            // return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
        }

        // $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        return $this->persist($data, $context);
    }

    /**
     * @param CommentResource $data
     *
     * @throws \Exception
     */
    public function persist($data, array $context = []): CommentResource
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $groups = [];
        if (!$user instanceof UserInterface) {
            $groups = ['anonymous'];
        } else {
            $groups = ['Default'];
        }
        $this->validator->validate($data, ['groups' => $groups]);

        if (null !== $data->entity) {
            $comment = $this->service->update($data->entity, $data->content);
        } else {
            $comment = $this->service->create($data);
        }

        return CommentResource::fromComment($comment);
    }

    /**
     * @param CommentResource $data
     */
    public function remove($data, array $context = []): CommentResource
    {
        if (null === $data->id) {
            return $data;
        }
        $this->service->delete($data->id);

        return $data;
    }
}
