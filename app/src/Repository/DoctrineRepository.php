<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\BuildableFromDTO;

class DoctrineRepository extends ServiceEntityRepository
{
    protected static string $entity = '';
    protected int $chunk = 0;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, static::$entity);
    }

    public function findIn(array $ids): iterable
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    public function save(BuildableFromDTO $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->flush();
            $this->refresh($entity);
        }
    }

    public function saveChunk(BuildableFromDTO $entity, int $chunk = 10, bool $forceInit = false): void
    {
        if ($forceInit) {
            $this->flushChunk();
        }

        $this->save($entity, false);

        $this->chunk++;

        if ($chunk <= $this->chunk) {
            $this->flushChunk();
        }
    }

    public function remove(BuildableFromDTO $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->flush();
        }
    }

    public function refresh(BuildableFromDTO $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function clear(): void
    {
        $this->getEntityManager()->clear();
    }

    public function flushChunk(): void
    {
        $this->chunk = 0;
        $this->flush();
    }
}
