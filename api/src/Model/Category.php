<?php

declare(strict_types=1);

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * Class Category
 * @package App\Model
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"category:detail"}},
 *     collectionOperations={},
 *     itemOperations={"get"}
 * )
 */
class Category
{
    /**
     * @var
     * @ApiProperty(identifier=true)
     * @Serializer\Groups({"category:detail","catalog:detail"})
     */
    public $id;

    /**
     * @var string
     * @Serializer\Groups({"category:detail", "catalog:detail"})
     */
    public $name;

    /**
     * @var Catalog[]
     * @Serializer\Groups({"category:detail"})
     */
    public $catalogs;

    /**
     * Category constructor.
     * @param $id
     * @param string $name
     * @param Collection $catalogs
     */
    public function __construct($id, string $name, Collection $catalogs)
    {
        $this->id       = (int) $id;
        $this->name     = $name;
        $this->catalogs = $catalogs;
    }

}