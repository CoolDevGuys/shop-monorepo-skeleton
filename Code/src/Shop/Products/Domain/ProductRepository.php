<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shared\Domain\Criteria\Criteria;
use CoolDevGuys\Shop\Shared\Domain\Products\ProductId;

interface ProductRepository
{
    public function find(ProductId $productId): ?Product;

    public function search(Criteria $criteria): Products;

    public function countByCriteria(Criteria $criteria): int;
}
