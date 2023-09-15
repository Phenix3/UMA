<?php

declare(strict_types=1);

namespace App\Http\Security;

use App\Domain\Blog\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    final public const POST_SHOW = 'show';

    public function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::POST_SHOW], true) && ($subject instanceof Post);
    }

    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return $subject->getCreatedAt() < new \DateTime('-2 hours');
    }
}
