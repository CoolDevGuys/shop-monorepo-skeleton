<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Domain\ValueObject;

use CoolDevGuys\Shared\Domain\Collection;
use function Lambdish\Phunctional\map;

final class FiltersQueryParam extends Collection implements \Stringable
{
    protected function type(): string
    {
        return FilterQueryParam::class;
    }

    public function __toString(): string
    {
        $str = '';
        $this->each(
            static function (FilterQueryParam $filter) use (&$str)
            {
                if (empty($str)) {
                    $str = $filter->__toString();
                } else {
                    $str .= '&' . $filter->__toString();
                }
            }
        );

        return $str;
    }

    public function asArray(): array
    {
        return map(
            function (FilterQueryParam $filter)
            {
                return $filter->toArray();
            },
            $this->items()
        );
    }

    public static function fromArray(array $filters): self
    {
        if (empty($filters)) {
            throw new \RuntimeException('Empty filters array provided');
        }
        return new self(
            map(
                function (array $filter)
                {
                    return FilterQueryParam::fromArray($filter);
                },
                $filters
            )
        );
    }

    public function toArray(): array
    {
        return map(fn(FilterQueryParam $param) => $param->toArray(), $this->items());
    }
}
