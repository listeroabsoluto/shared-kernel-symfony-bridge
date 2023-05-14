<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Type;

use Symfony\Bridge\Doctrine\Types\AbstractUidType;

/**
 * Class IdentifierType
 * @package App\Infrastructure\Doctrine\ORM\Type
 */
abstract class IdentifierType extends AbstractUidType
{

    abstract protected function getClass();

    abstract protected function fromUuid($value);

    public const NAME = 'uuid';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getUidClass(): string
    {
        return $this->getClass();
    }

}
