<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use SharedKernel\Domain\ValueObject\Email;

/**
 * Class EmailType
 * @package SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Type
 */
class EmailType extends Type
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'email';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (is_scalar($value)) {
            try {
                $value = Email::fromAddress($value);
            } catch (\InvalidArgumentException) {
                throw ConversionException::conversionFailedFormat($value, $this->getName(), Email::class);
            }
        }
        if (!is_a($value, Email::class)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [Email::class]);
        }

        return (string)$value;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return Email::fromAddress($value);
    }

    /**
     * @param array $column
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 16;
        $column['fixed'] = true;

        return $platform->getBinaryTypeDeclarationSQL($column);
    }
}
