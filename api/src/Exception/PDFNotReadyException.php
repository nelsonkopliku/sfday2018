<?php

declare(strict_types=1);

namespace App\Exception;

use App\Entity\Catalog;

/**
 * Class PDFNotReadyException
 * @package App\Exception
 */
class PDFNotReadyException extends \Exception
{
    public function __construct(Catalog $catalog)
    {
        parent::__construct(sprintf('PDF for catalog "%s" is not ready yet', $catalog->getName()) , 0, null);
    }
}