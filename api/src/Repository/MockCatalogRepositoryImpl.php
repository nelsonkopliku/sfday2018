<?php

declare(strict_types=1);

namespace App\Repository;

use App\Interfaces\RepositoryInterface;
use App\Model\Catalog;
use App\Model\Category;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Common\Collections\{
    ArrayCollection, Collection, Criteria
};

/**
 * Class MockCatalogRepositoryImpl
 * @package App\Repository
 */
class MockCatalogRepositoryImpl implements RepositoryInterface
{
    /**
     * @var SlugifyInterface
     */
    private $slugger;

    /**
     * @var ArrayCollection
     */
    private $data;

    /**
     * CatalogDataProvider constructor.
     * @param SlugifyInterface $slugger
     */
    public function __construct(SlugifyInterface $slugger/**, SomeNoSqlClientInterface $client */ )
    {
        $this->slugger = $slugger;
        $this->data    = new ArrayCollection();
        $this->loadMockData();
    }

    private function loadMockData(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $catalog             = new Catalog();
            $catalog->id         = $i+1;
            $catalog->name       = sprintf('catalog #%s', $i+1);
            $catalog->slug       = $this->slugger->slugify($catalog->name);
            $catalog->category   = new Category($i+6, sprintf('Category #%s', $i+6), new ArrayCollection());
            $catalog->pages      = random_int(20, 255);
            $catalog->lastModify = new \DateTime('1970-01-01');
            $catalog->file       = sprintf('http://cnd.mycdn.com/catalogues/%s', $i+1);
            $this->data->add($catalog);
        }
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function findAll() : Collection
    {
        //get all your data from your persistence layer
        //here just return loaded mocks
        return $this->data;
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function find($id)
    {
        //Extract one exact item from your persistence layer
        //in this case just filter on mocked data
       return $this->data->matching(
           Criteria::create()
               ->where(Criteria::expr()->eq('id', $id))
       )->first() ?: null;
    }

    /**
     * @param $item
     * @return mixed
     * @throws \Exception
     */
    public function persist($item)
    {
        /** @var Catalog $item */
        //Create or update something in your persistence layer, using some service

        $foundItem = $this->find($item->id);

        return $foundItem ? $this->updateItem($foundItem, $item) : $this->createItem($item);
    }

    /**
     * @param $item
     */
    public function remove($item) : void
    {
        //Remove the element from your persistence layer
        //in this case remove element from ArrayCollection
        $this->data->removeElement($item);
    }

    private function updateItem($item, $newItem)
    {
        //some magic and return updated item
        /** @var Catalog $item */
        /** @var Catalog $newItem */
        $item->name       = $newItem->name ?? $item->name;
        $item->slug       = $newItem->slug ?? $item->slug;
        $item->pages      = $newItem->pages ?? $item->pages;
        $item->lastModify = new \DateTime('1970-01-01');
        $item->file       = $newItem->file ?? $item->file;
        return $item;
    }

    private function createItem($item)
    {
        //some magic and return created item
        $item->id = $this->data->last()->id + 1;
        $item->lastModify = new \DateTime('1970-01-01');
        $this->data->add($item);

        return $item;
    }
}
