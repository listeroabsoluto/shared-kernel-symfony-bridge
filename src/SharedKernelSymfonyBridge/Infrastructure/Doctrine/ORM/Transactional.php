<?php

namespace SharedKernelSymfonyBridge\Infrastructure\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
use SharedKernel\Application\TransactionalInterface;

/**
 * Class Transactional
 * @package App\App\Infrastructure\Doctrine
 */
class Transactional implements TransactionalInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * Transactional constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param \Closure $closure
     * @return mixed
     */
    public function execute(\Closure $closure): mixed
    {
        return $this->manager->wrapInTransaction($closure);
    }
}