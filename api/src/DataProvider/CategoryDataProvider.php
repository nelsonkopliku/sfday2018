<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\{
    ItemDataProviderInterface, RestrictedDataProviderInterface
};
use App\Model\Category;
use App\Util\Traits\RepositoryAwareTrait as CatalogRepositoryAwareTrait;

/**
 * Class CatalogDataProvider
 * @package App\DataProvider
 */
class CategoryDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    use CatalogRepositoryAwareTrait{
        getRepository as getCatalogRepository;
    }

    /**
     * Checks if current DataProvider is suitable
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Category::class === $resourceClass;
    }

    /**
     * Retrieves the item from the persistence layer
     * @param string $resourceClass
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     * @return mixed|null|object
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return new Category($id, 'Fake Category', $this->getCatalogRepository()->findAll());
    }

}