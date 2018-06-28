<?php

declare(strict_types=1);

namespace Organization\Exception;

use DomainException;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class AlreadyAnOrganizerException extends DomainException
{
    public static function create(UserEntity $user, OrganizationEntity $organization): self
    {
        $message = sprintf('%s is already an organizer of %s', $user->getUsername(), $organization->getTitle());

        return new self($message);
    }
}
