<?php

namespace SharedKernelSymfonyBridge\Infrastructure;

use SharedKernel\Application\TransactionalDecorator;
use SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM\Transactional;
use SharedKernelSymfonyBridge\Infrastructure\Service\EventBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 *
 */
class TransactionalDecoratorPass implements CompilerPassInterface
{
    public function process(\Symfony\Component\DependencyInjection\ContainerBuilder $container): void
    {
        if (!$container->has(TransactionalDecorator::class)) {
            // If the decorator isn't registered in the container you could register it here
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('shared.transactional_decorated');

        foreach ($taggedServices as $id => $tags) {

            // skip the decorator, we do it's not self-decorated
            if ($id === TransactionalDecorator::class) {
                continue;
            }

            $decoratedServiceId = $this->generateAliasName($id);

            // Add the new decorated service.
            $container->register($decoratedServiceId, TransactionalDecorator::class)
                ->setDecoratedService($id)
                ->setPublic(true)
                ->setAutowired(false)
                ->setArgument(0, $container->getDefinition(Transactional::class))
                ->setArgument(1, $container->getDefinition(EventBus::class))
                ->setArgument(2, $container->getDefinition($id))
                ->setMethodCalls();
        }
    }

    /**
     * @param $serviceName
     * @return string
     */
    private function generateAliasName($serviceName): string
    {
        if (str_contains($serviceName, '\\')) {
            $parts = explode('\\', $serviceName);
            $className = end($parts);
            $alias = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($className)));
        } else {
            $alias = $serviceName;
        }

        return $alias.'_decorator';
    }
}