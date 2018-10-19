<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreatePdfAction;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"catalog:list"}},
 *     denormalizationContext={"groups"={"catalog:write"}},
 *     collectionOperations={
 *          "get"={
 *              "method"="GET"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "normalization_context"={"groups"={"catalog:detail"}},
 *              "validation_groups"={"v:create"},
 *              "defaults"={
 *                  "_publish_on_create"={"channel"="catalog_created"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "normalization_context"={"groups"={"catalog:detail"}, "datetime_format"="Y-m-d\TH:i:s"}
 *          },
 *          "put"={"method"="PUT", "normalization_context"={"groups"={"catalog:detail"}}},
 *          "patch"={"method"="PATCH", "normalization_context"={"groups"={"catalog:detail"}}},
 *          "delete"={"method"="DELETE"},
 *          "create_pdf"={
 *              "method"="POST",
 *              "path"="/catalogs/{id}/create-pdf",
 *              "controller"=CreatePdfAction::class,
 *              "defaults"={
 *                  "_api_respond"=false,
 *                  "_api_swagger_context"={
 *                      "tags"={"Catalog"},
 *                      "summary"="Create a PDF",
 *                      "parameters"={{"name"="id", "in"="path", "required"=true, "type"="string", "description"="Catalog's ID"}},
 *                      "responses"={
 *                          "202"={
 *                              "description"="OK, got request. Someone is going to process it in background."
 *                          }
 *                      }
 *                  }
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DoctrineCatalogRepositoryImpl")
 * @UniqueEntity("name", groups={"v:create"})
 * @UniqueEntity("slug", groups={"v:create"})
 *
 */
class Catalog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid", unique=true)
     *
     * @Assert\Uuid()
     *
     * @Serializer\Groups({"catalog:list", "catalog:detail"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="255")
     *
     * @Serializer\Groups({"catalog:write", "catalog:list", "catalog:detail" ,"category:detail"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"catalog:write", "catalog:detail", "category:detail"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     *
     * @Assert\Type(type="integer")
     * @Serializer\Groups({"catalog:write"})
     *
     * @ORM\Column(type="integer")
     */
    private $pages;

    /**
     * @Serializer\Groups({"catalog:detail", "category:detail"})
     *
     * @ORM\Column(type="datetime")
     */
    private $lastModify;

    /**
     * @Serializer\Groups({"catalog:write", "catalog:list", "catalog:detail"})
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @Serializer\Groups({"catalog:detail"})
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="catalogs")
     */
    private $category;

    /**
     * Catalog constructor.
     */
    public function __construct()
    {
        $this->lastModify = new \DateTime('1970-01-01');
        $this->pages      = 0;
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
     * @return Catalog
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Catalog
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPages(): ?int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     * @return Catalog
     */
    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastModify(): ?\DateTimeInterface
    {
        return $this->lastModify;
    }

    /**
     * @param \DateTimeInterface $lastModify
     * @return Catalog
     */
    public function setLastModify(\DateTimeInterface $lastModify): self
    {
        $this->lastModify = $lastModify;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return Catalog
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return Catalog
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
