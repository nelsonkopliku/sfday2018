<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\{
    CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
};
//use App\Model\Catalog;
use App\Entity\Catalog;
use App\Util\Traits\RepositoryAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class CatalogDataProvider
 * @package App\DataProvider
 */
class CatalogDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    use RepositoryAwareTrait;

    /**
     * Checks if current DataProvider is suitable
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalog::class === $resourceClass;
    }

    /**
     * Retrieves the collection from the persistence layer
     * @param string $resourceClass
     * @param string|null $operationName
     * @return Collection
     * @throws \Exception
     */
    public function getCollection(string $resourceClass, string $operationName = null) : Collection
    {
        $collection = $this->repo->findAll();
        return $collection instanceof Collection ? $collection : new ArrayCollection($collection);
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
        return $this->repo->find($id);
    }

}