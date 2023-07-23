<?php

namespace App\Http\Api\Processor;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Domain\Auth\Entity\User;
use App\Domain\Comment\CommentService;
use App\Http\Api\Resource\CommentResource;
use Symfony\Bundle\SecurityBundle\Security;

class CommentProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly Security $security,
        private readonly CommentService $service
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof DeleteOperationInterface) {
            return $this->remove($data, $context);
        }

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
        if (!$user instanceof User) {
            $groups = ['anonymous'];
        }
        $this->validator->validate($data, ['groups' => $groups]);

        if (null !== $data->entity) {
            $comment = $this->service->update($data->entity, $data->content);
        } else {
            $comment = $this->service->create($data);
        }
        // dd($data);

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
