<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Catalog;
use Ramsey\Uuid\Uuid;

/**
 * Class CreatePdf
 * @package App\Message
 */
class CreatePdf
{
    /**
     * @var Uuid
     */
    private $catalogId;

    /**
     * @var string
     */
    private $sourceFile;

    /**
     * CreatePdf constructor.
     * @param Catalog $catalog
     */
    public function __construct(Catalog $catalog)
    {
        $this->catalogId  = $catalog->getId();
        $this->sourceFile = $catalog->getFile();
    }

    /**
     * @return Uuid
     */
    public function getCatalogId() : Uuid
    {
        return $this->catalogId;
    }

    /**
     * @return string
     */
    public function getSourceFile() : string
    {
        return $this->sourceFile;
    }
}