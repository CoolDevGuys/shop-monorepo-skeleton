<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Infrastructure\Persistence;

use CoolDevGuys\Shared\Domain\Criteria\Criteria;
use CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use CoolDevGuys\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use CoolDevGuys\Shop\Products\Domain\Product;
use CoolDevGuys\Shop\Products\Domain\ProductRepository;
use CoolDevGuys\Shop\Products\Domain\Products;
use CoolDevGuys\Shop\Shared\Domain\Products\ProductId;

final class DoctrineProductRepository extends DoctrineRepository implements ProductRepository
{

    public function find(ProductId $productId): ?Product
    {
        /** @var ?Product $product */
        $product = $this->repository(Product::class)->find($productId);
        return $product;
    }

    public function search(Criteria $criteria): Products
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
        $products = $this->repository(Product::class)->matching($doctrineCriteria)->toArray();
        return new Products($products);
    }


    /**
     * @throws \Doctrine\ORM\Query\QueryException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function countByCriteria(Criteria $criteria): int
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        $qb = $this->entityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('p'))
           ->from(Product::class, 'p')->addCriteria($doctrineCriteria);

        $query = $qb->getQuery();

        return (int)$query->getSingleScalarResult();
    }
}
