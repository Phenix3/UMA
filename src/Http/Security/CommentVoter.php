<?php

namespace App\Http\Security;

use App\Domain\Auth\Entity\User;
use App\Domain\Comment\Comment;
use App\Http\Api\Resource\CommentResource;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;


class CommentVoter extends Voter
{
    final public const DELETE = 'delete';
    final public const UPDATE = 'update';

    public function __construct(private Security $security)
    {
        
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [
            self::DELETE,
            self::UPDATE,
        ]) && ($subject instanceof Comment || $subject instanceof CommentResource);
    }

    /**
     * @param string                  $attribute
     * @param Comment|CommentResource $subject
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        
        // dd($attribute, $subject, $user);
        
        if (!$user instanceof UserInterface) {
            return false;
        }
        
        if ($subject instanceof CommentResource) {
            $subject = $subject->entity;
        }
        
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        
        if (null === $subject) {
            return false;
        }

        return null !== $subject->getAuthor() && $subject->getAuthor()->getId() === $user->getId();
    }
}
