<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"category:detail"}, "datetime_format"="Y-m-d\TH:i:s"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DoctrineCategoryRepositoryImpl")
 * @UniqueEntity("name")
 * @UniqueEntity("slug")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid", unique=true)
     *
     * @Assert\Uuid()
     *
     * @Serializer\Groups({"category:detail","catalog:detail"})
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"category:detail", "catalog:detail"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Catalog[]
     *
     * @Serializer\Groups({"category:detail"})
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Catalog", mappedBy="category")
     * @ORM\OrderBy({"name" = "DESC"})
     */
    private $catalogs;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->catalogs = new ArrayCollection();
    }

    /**
     * @return null|Uuid
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Catalog[]
     */
    public function getCatalogs(): Collection
    {
        return $this->catalogs;
    }

    /**
     * @param Catalog $catalog
     * @return Category
     */
    public function addCatalog(Catalog $catalog): self
    {
        if (!$this->catalogs->contains($catalog)) {
            $this->catalogs[] = $catalog;
            $catalog->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Catalog $catalog
     * @return Category
     */
    public function removeCatalog(Catalog $catalog): self
    {
        if ($this->catalogs->contains($catalog)) {
            $this->catalogs->removeElement($catalog);
            // set the owning side to null (unless already changed)
            if ($catalog->getCategory() === $this) {
                $catalog->setCategory(null);
            }
        }

        return $this;
    }
}
