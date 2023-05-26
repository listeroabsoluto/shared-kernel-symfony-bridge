<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Controller;

use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *
 */
readonly class JsonResponder
{
    public function __construct(
        private AutoMapperInterface $mapper,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @param $data
     * @param string|null $type
     * @return JsonResponse
     * @throws UnregisteredMappingException
     */
    public function asJsonResponse($data, string $type = null): JsonResponse
    {
        if (is_iterable($data)) {
            if ($type) {
                $mapped = $this->mapper->mapMultiple($data, $type);
            } else {
                $mapped = $data;
            }
        } elseif ($type) {
            $mapped = $this->mapper->map($data, $type);
        } else {
            $mapped = $data;
        }


        $json = $this->serializer->serialize(
            $mapped,
            'json',
            ['json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,]
        );

        return new JsonResponse(data: $json, json: true);
    }
}