<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Controller;

use AutoMapperPlus\AutoMapperInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *
 */
class JsonResponderTest extends TestCase
{

    public function testAsJsonResponseIterableNotMap()
    {
        $data = [];

        $mapper = $this->getMockBuilder(AutoMapperInterface::class)->getMock();
        $mapper->expects(self::never())->method('mapMultiple')
            ->willReturn($data);

        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMock();
        $serializer->expects(self::once())->method('serialize')
            ->willReturn("[]");

        $responder = new JsonResponder($mapper, $serializer);

        $actual = $responder->asJsonResponse($data);

        static::assertEquals(new JsonResponse([]), $actual);
    }

    public function testAsJsonResponseIterableMap()
    {
        $data = [];

        $mapper = $this->getMockBuilder(AutoMapperInterface::class)->getMock();
        $mapper->expects(self::once())->method('mapMultiple')
            ->willReturn($data);

        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMock();
        $serializer->expects(self::once())->method('serialize')
            ->willReturn("[]");

        $responder = new JsonResponder($mapper, $serializer);

        $actual = $responder->asJsonResponse($data, \stdClass::class);

        static::assertEquals(new JsonResponse([]), $actual);
    }

    public function testAsJsonResponseObjectNotMap()
    {
        $data = new \stdClass();

        $mapper = $this->getMockBuilder(AutoMapperInterface::class)->getMock();
        $mapper->expects(self::never())->method('map')
            ->willReturn($data);

        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMock();
        $serializer->expects(self::once())->method('serialize')
            ->willReturn("[]");

        $responder = new JsonResponder($mapper, $serializer);

        $actual = $responder->asJsonResponse($data);

        static::assertEquals(new JsonResponse([]), $actual);
    }

    public function testAsJsonResponseObjectMap()
    {
        $data = new \stdClass();

        $mapper = $this->getMockBuilder(AutoMapperInterface::class)->getMock();
        $mapper->expects(self::once())->method('map')
            ->willReturn($data);

        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMock();
        $serializer->expects(self::once())->method('serialize')
            ->willReturn("[]");

        $responder = new JsonResponder($mapper, $serializer);

        $actual = $responder->asJsonResponse($data, \stdClass::class);

        static::assertEquals(new JsonResponse([]), $actual);
    }
}
