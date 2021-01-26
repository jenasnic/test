<?php

namespace App\Service\Api\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Query\Expr\Join;

class TestFilter implements FilterInterface
{
    private RequestStack $requestStack;

    private string $property;

    public function __construct(RequestStack $requestStack, string $property)
    {
        $this->requestStack = $requestStack;
        $this->property = $property;
    }

    public function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (null === $this->requestStack || null === $request = $this->requestStack->getCurrentRequest()) {
            return;
        }

        if (!$request->query->has('brand')) {
            return;
        }

        $brand = $request->get('brand', null);
        $period = $request->get('period', null);
        $allBrand = $request->get('allBrand');

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $itemAlias = ($queryNameGenerator->generateJoinAlias('items'));
        $brandAlias = ($queryNameGenerator->generateJoinAlias('brand'));

        if (!is_array($brand)) {
            $brand = [$brand];
        }

        if (null === $period) {
            $queryBuilder->innerJoin(sprintf('%s.%s', $rootAlias, $this->property), $itemAlias);
        } else {
            $queryBuilder
                ->innerJoin(
                    sprintf('%s.%s', $rootAlias, $this->property),
                    $itemAlias,
                    Join::WITH,
                    sprintf('%s.availableAt <= :startDate AND %s.expireAt >= :endDate', $itemAlias, $itemAlias)
                )
            ;
        }

        $queryBuilder
            ->innerJoin(
                sprintf('%s.brand', $itemAlias),
                $brandAlias,
                Join::WITH,
                sprintf('%s.code IN (:codes)', $brandAlias)
            )
            ->setParameter('codes', $brand)
        ;

        if (null !== $allBrand && 1 === intval($allBrand)) {
            $queryBuilder
                ->groupBy(sprintf('%s.id', $rootAlias))
                ->having(sprintf('COUNT(%s.id) >= %d', $brandAlias, count($brand)))
            ;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        $description = [];

        $description['brand'] = [
            'property' => 'items.brand.code',
            'type' => 'string',
            'required' => false,
            'is_collection' => true,
        ];

        $description['period'] = [
            'property' => 'items.availableAt, item.expireAt',
            'type' => 'datetime',
            'required' => false,
            'is_collection' => false,
        ];

        $description['period[start]'] = [
            'property' => 'items.availableAt',
            'type' => 'datetime',
            'required' => false,
            'is_collection' => false,
        ];

        $description['period[end]'] = [
            'property' => 'items.expireAt',
            'type' => 'datetime',
            'required' => false,
            'is_collection' => false,
        ];

        $description['allBrand'] = [
            'property' => 'items',
            'type' => 'integer',
            'required' => false,
            'is_collection' => false,
        ];

        return $description;
    }
}
