<?php

declare(strict_types=1);

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreatePdfAction;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * Class Catalog
 * @package App\Model
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"catalog:list"}},
 *     denormalizationContext={"groups"={"catalog:write"}},
 *     collectionOperations={
 *          "get"={
 *              "method"="GET"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "normalization_context"={"groups"={"catalog:detail"}}
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "normalization_context"={"groups"={"catalog:detail"}}
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
 */
class Catalog
{
    /**
     * @var int
     * @ApiProperty(identifier=true)
     * @Serializer\Groups({"catalog:list", "catalog:detail"})
     */
    public $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="255")
     *
     * @Serializer\Groups({"catalog:write", "catalog:list", "catalog:detail" ,"category:detail"})
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"catalog:write", "catalog:detail", "category:detail"})
     */
    public $slug;

    /**
     * @var Category
     * @Serializer\Groups({"catalog:detail"})
     */
    public $category;

    /**
     * @var int
     *
     * @Serializer\Groups({"catalog:write"})
     */
    public $pages;

    /**
     * @var \DateTime
     * @Serializer\Groups({"catalog:detail", "category:detail"})
     */
    public $lastModify;

    /**
     * @var string
     *
     * @Assert\Url()
     *
     * @Serializer\Groups({"catalog:write", "catalog:list", "catalog:detail"})
     */
    public $file;
}
