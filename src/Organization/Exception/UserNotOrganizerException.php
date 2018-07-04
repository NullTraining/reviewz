<?php

declare(strict_types=1);

namespace Organization\Exception;

use DomainException;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class UserNotOrganizerException extends DomainException
{
    public static function user(UserEntity $user, OrganizationEntity $organization)
    {
        $message = sprintf(
            'User %s is not a valid %s organization organizer!',
            $user->getUsername(),
            $organization->getTitle()
        );

        return new self($message);
    }
}
