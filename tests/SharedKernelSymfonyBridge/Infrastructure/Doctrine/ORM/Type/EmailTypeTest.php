<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\ValueObject\Email;

/**
 * Class EmailTypeTest
 * @package App\Infrastructure\Doctrine\ORM\Type
 */
class EmailTypeTest extends TestCase
{

    public function testConvertToDatabaseValueNonScalar()
    {
        self::expectException(ConversionException::class);
        $platform = self::getMockBuilder(AbstractPlatform::class)->getMock();

        $emailType = new EmailType();
        $emailType->convertToDatabaseValue(['non scalar'], $platform);
    }

    public function testConvertToDatabaseValueNonEmail()
    {
        self::expectException(ConversionException::class);
        $platform = self::getMockBuilder(AbstractPlatform::class)->getMock();

        $emailType = new EmailType();
        $emailType->convertToDatabaseValue('non email', $platform);
    }

    public function testConvertToDatabaseValue()
    {
        $platform = self::getMockBuilder(AbstractPlatform::class)->getMock();

        $emailType = new EmailType();
        $actual = $emailType->convertToDatabaseValue('jhon@doe.com', $platform);
        self::assertEquals('jhon@doe.com', $actual);

        $actual = $emailType->convertToDatabaseValue(Email::fromAddress('jhon@doe.com'), $platform);
        self::assertEquals('jhon@doe.com', $actual);
    }

    public function testConvertToPHP()
    {
        $platform = self::getMockBuilder(AbstractPlatform::class)->getMock();

        $emailType = new EmailType();
        $actual = $emailType->convertToPHPValue('jhon@doe.com', $platform);
        self::assertInstanceOf(Email::class, $actual);
    }

    public function testGetSQLDeclaration()
    {
        $platform = self::getMockBuilder(AbstractPlatform::class)->getMock();
        $platform->expects(self::once())->method('getBinaryTypeDeclarationSQL')->willReturn('BINARY');

        $emailType = new EmailType();
        $actual = $emailType->getSQLDeclaration([], $platform);
        self::assertIsString($actual);
        self::assertEquals('BINARY', $actual);
    }

    public function testGetName()
    {
        $emailType = new EmailType();
        $actual = $emailType->getName();
        self::assertEquals('email', $actual);
    }
}
