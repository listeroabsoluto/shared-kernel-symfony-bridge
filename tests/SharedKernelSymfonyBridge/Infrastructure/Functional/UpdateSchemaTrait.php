<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Functional;

use Doctrine\ORM\Tools\SchemaTool;

/**
 *
 */
trait UpdateSchemaTrait
{
    private function updateSchema(): void
    {
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        // Runs the schema update tool using our entity metadata
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropDatabase();
        $schemaTool->updateSchema($classes);
    }
}