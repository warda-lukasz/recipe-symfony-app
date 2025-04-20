<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    protected static string $alias = 'e';
    protected static string $entity = '';
    protected static string $sortField = '';

    public function __construct(
        protected EntityManagerInterface $em,
        protected PaginatorInterface $paginator,
    ) {}

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->em->getRepository(static::$entity)
            ->createQueryBuilder(static::$alias);
    }

    protected function filter(
        Request $req,
        QueryBuilder $queryBuilder = null
    ): Query {
        $queryBuilder = $queryBuilder ?? $this->getQueryBuilder();

        $field = $req->query->getString('filterField') ?? null;
        $val = $req->query->getString('filterValue') ?? null;

        if ($field && $val) {
            $queryBuilder->where("{$field} LIKE :val")
                ->setParameter('val', '%' . $val . '%');
        }

        $queryBuilder->orderBy(
            static::$alias . '.' . static::$sortField,
            $req->query->getString('sort', 'asc')
        );

        return $queryBuilder->getQuery();
    }

    protected function paginate(
        Request $req,
        QueryBuilder $queryBuilder = null
    ): PaginationInterface {
        return $this->paginator->paginate(
            $this->filter($req, $queryBuilder),
            $req->query->getInt('page', 1),
            $req->query->getInt('limit', 6)
        );
    }
}
