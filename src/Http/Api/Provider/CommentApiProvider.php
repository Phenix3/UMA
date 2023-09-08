<?php

namespace App\Http\Api\Provider;

use ApiPlatform\Exception\RuntimeException;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Comment\Comment;
use App\Domain\Comment\CommentRepository;
use App\Http\Api\Resource\CommentResource;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class CommentApiProvider implements ProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly CommentRepository $commentRepository,
        private readonly UploaderHelper $uploaderHelper
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->getCollection($operation->getClass(), $operation->getName());
        }

        return $this->getItem(
            $operation->getClass(),
            $uriVariables['id'],
            $operation->getName(),
            $context
        );
    }

    /**
     * @return array<CommentResource>
     */
    public function getCollection(string $resourceClass, string $operationName = null): array
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            throw new RuntimeException('Requête introuvable');
        }
        $contentId = $request->get('content');
        if (!$contentId) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Aucun contenu ne correspond à cet ID');
        }

        return array_map(
            fn (Comment $comment) => CommentResource::fromComment($comment, $this->uploaderHelper),
            $this->commentRepository->findForApi($contentId)
        );
    }

    /**
     * @param int|array $id
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): ?CommentResource {
        if (is_array($id)) {
            throw new RuntimeException('id as array not expected');
        }

        $comment = $this->commentRepository->findPartial($id);

        return $comment ? CommentResource::fromComment($comment, $this->uploaderHelper) : null;
    }
}
