<?php

namespace App\Security;

use App\Entity\Course;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CourseVoter extends Voter
{
    protected const EDIT = 'edit';
    protected const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!\in_array($attribute, [self::EDIT, self::DELETE], true)) {
            return false;
        }

        if (!$subject instanceof Course) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        /** @var Course $course */
        $course = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($course, $user);
            case self::DELETE:
                return $this->canDelete($course, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Course $course, User $user)
    {
        return $user === $course->getAuthor();
    }

    private function canDelete(Course $course, User $user)
    {
        return $user === $course->getAuthor();
    }
}
