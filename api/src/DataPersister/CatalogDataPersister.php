<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Model\Catalog;
use App\Util\Traits\RepositoryAwareTrait;

/**
 * Class CatalogDataProvider
 * @package App\DataProvider
 */
class CatalogDataPersister implements DataPersisterInterface
{
    use RepositoryAwareTrait;

    /**
     * @param $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof Catalog;
    }

    /**
     * @param $data
     * @return object
     */
    public function persist($data)
    {
        return $this->repo->persist($data);
    }

    /**
     * @param $data
     */
    public function remove($data)
    {
        $this->repo->remove($data);
    }

}