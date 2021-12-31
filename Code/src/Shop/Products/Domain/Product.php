<?php

declare(strict_types=1);

namespace CoolDevGuys\Shop\Products\Domain;

use CoolDevGuys\Shared\Domain\Aggregate\AggregateRoot;
use CoolDevGuys\Shared\Domain\ValueObject\DateValueObject;
use CoolDevGuys\Shop\Products\Domain\ValueObject\ProductName;
use CoolDevGuys\Shop\Shared\Domain\Products\ProductId;

final class Product extends AggregateRoot
{
    private const ENTITY_TYPE = 'products';

    private DateValueObject $createdAt;
    private ?DateValueObject $updatedAt;

    public function __construct(private ProductId $id, private ProductName $name, private ProductPrice $price)
    {
        $this->createdAt = DateValueObject::now();
        $this->updatedAt = null;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function update(ProductData $productData): void
    {
        $updated = false;
        foreach ($productData->properties() as $property) {
            $data = $productData->$property();
            if (null !== $data) {
                $this->$property = $data;
                $updated = true;
            }
        }

        if ($updated) {
            $this->updatedAt = DateValueObject::now();
        }
    }

    public function toJsonApiResponseArray(string $baseUrl): array
    {
        $attr = $this->toArray();
        unset($attr['id']);
        return [
            'id' => $this->id->value(),
            'type' => self::ENTITY_TYPE,
            'attributes' => $attr,
            'links' => ['self' => $baseUrl . '/' . $this->id->value()]
        ];
    }

    public function toArray(): array
    {
        return ['id' => $this->id->value(), 'name' => $this->name->value(), 'price' => $this->price->value()];
    }
}
