<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Catalog;
use App\Exception\PDFNotReadyException;
use App\Util\{ CatalogPdfChecker, OperationInfoExtractor };
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CatalogSubscriber
 * @package App\EventSubscriber
 */
class CatalogSubscriber implements EventSubscriberInterface
{
    /**
     * @var OperationInfoExtractor
     */
    private $infoExtractor;

    /**
     * @var CatalogPdfChecker
     */
    private $pdfChecker;

    /**
     * CatalogSubscriber constructor.
     * @param OperationInfoExtractor $infoExtractor
     * @param CatalogPdfChecker $pdfChecker
     */
    public function __construct(OperationInfoExtractor $infoExtractor, CatalogPdfChecker $pdfChecker)
    {
        $this->infoExtractor = $infoExtractor;
        $this->pdfChecker    = $pdfChecker;
    }

    /**
     * @param GetResponseEvent $event
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if ($event->hasResponse()) {
            return;
        }

        $request = $event->getRequest();

        if (
            $this->infoExtractor->isItemOperationForResource($request, Catalog::class) &&
            $request->isMethodSafe(false)
        ) {
            /** @var Catalog $loadedCatalog */
            $loadedCatalog = $event->getRequest()->attributes->get('data');
            if (!$this->pdfChecker->isPdfGenerated($loadedCatalog)) {
                throw new PDFNotReadyException($loadedCatalog);
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest', EventPriorities::POST_READ
            ]
        ];
    }
}
