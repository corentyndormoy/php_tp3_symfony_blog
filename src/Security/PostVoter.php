<?php

namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PostVoter extends Voter
{
    const CREATE = 'create';
    const EDIT = 'edit';

    const AUTHOR = 'ROLE_AUTHOR';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::CREATE, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Post) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate();
            case self::EDIT:
                return $this->canEdit($post, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * Détermine si l'utilisateur peut créer un article
     * 
     * @return bool
     */
    private function canCreate(): bool
    {
        return $this->isAuthor();
    }

    /**
     * Détermine si l'utilisateur peut modifier un article
     * 
     * @param Post $post
     * @param User $user
     * 
     * @return bool
     */
    private function canEdit(Post $post, User $user): bool
    {
        //S'il est l'auteur
        if ($post->getAuthor() === $user) {
            return true;
        }
        
        return false;
    }

    /**
     * Détermine si l'utilisateur connecté possède le rôle d'auteur
     * 
     * @return bool
     */
    private function isAuthor(): bool
    {
        if ($this->security->isGranted(self::AUTHOR)) {
            return true;
        }

        return false;
    }
}
