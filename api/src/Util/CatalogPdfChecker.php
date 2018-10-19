<?php

declare(strict_types=1);

namespace App\Util;

use App\Entity\Catalog;

/**
 * Class CatalogPdfChecker
 * @package App\Util
 */
class CatalogPdfChecker
{

    public function isPdfGenerated(Catalog $catalog) : bool
    {
        //check somehow if the PDF for the catalog is ready, has been processed

        // $maybeSomeRemoteClient->checkForPfdExistence($catalog->id);

        //example purpose
        return $catalog->getPages() < 150;
    }

}