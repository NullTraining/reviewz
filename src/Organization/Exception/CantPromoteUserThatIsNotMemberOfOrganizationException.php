<?php

declare(strict_types=1);

namespace Organization\Exception;

use DomainException;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;

class CantPromoteUserThatIsNotMemberOfOrganizationException extends DomainException
{
    public static function create(UserEntity $user, OrganizationEntity $organization): self
    {
        $message = sprintf(
            'In order to promote %s to organizer, user needs to be a member of %s first!',
            $user->getUsername(),
            $organization->getTitle()
        );

        return new self($message);
    }
}
