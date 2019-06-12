<?php

namespace App\Tests\Support;

use Doctrine\ORM\EntityManagerInterface;

trait Database
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @before
     */
    public function beginTransaction(): void
    {
        $this->entityManager = static::$container
            ->get('doctrine')
            ->getManager();

        $this->entityManager->beginTransaction();
    }

    /**
     * @after
     */
    public function rollbackTransaction(): void
    {
        $this->entityManager->rollback();
        $this->entityManager = null;
    }
}
