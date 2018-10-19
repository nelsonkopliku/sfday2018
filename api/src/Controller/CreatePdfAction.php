<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Catalog;
use App\Interfaces\DelegatableAction;
use App\Message\CreatePdf;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CreatePdfAction
 * @package App\Controller
 */
class CreatePdfAction implements DelegatableAction
{
    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * CreatePdfAction constructor.
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Catalog $data
     */
    public function __invoke(Catalog $data)
    {
        $this->bus->dispatch(new CreatePdf($data));
    }

}